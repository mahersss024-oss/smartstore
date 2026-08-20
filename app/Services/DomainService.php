<?php

namespace App\Services;

use App\Enums\Domain\SslStatusEnum;
use App\Models\Domain;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;
use Pdp\CannotProcessHost;
use Pdp\ResourceUri;
use Pdp\Rules;
use Spatie\Dns\Dns;
use Spatie\Dns\Records\A;
use Spatie\Dns\Records\CNAME;
use Spatie\Dns\Records\TXT;

class DomainService
{
    /**
     * Verify the domain ownership
     *
     *
     * @throws Exception
     */
    public function verifyDomain(?Domain $domain): object
    {
        if (! $domain) {
            throw new Exception('No domain found to verify.');
        }

        if ($domain->is_verified) {
            return (object) [
                'status' => true,
                'message' => 'Domain verified successfully!',
            ];
        }

        if ($domain->ssl_status == SslStatusEnum::SUCCESS) {
            throw new Exception('Domain is already verified and SSL certificate is issued.');
        }

        $dns = new Dns;
        $records = $dns->useNameserver('8.8.8.8')->getRecords($domain->name, 'TXT');

        $isVerified = false;
        foreach ($records as $record) {
            // Ensure the record is an instance of TXT and has the expected properties
            if (! $record instanceof TXT) {
                continue;
            }

            // Check if the TXT record matches the verification token
            if ($record->type() === 'TXT' && $record->txt() === $domain->verification_token) {
                $isVerified = true;
                break;
            }
        }

        if (! $isVerified) {
            throw new Exception('Domain verification failed. TXT record not found or does not match the expected token: '.$domain->verification_token);
        }

        $domain->is_verified = true;
        $domain->verified_at = now();
        $domain->save();

        return (object) [
            'status' => true,
            'message' => 'Domain verified successfully!',
        ];
    }

    /**
     * Issue SSL certificate for a domain using Certbot
     *
     *
     * @throws Exception If the operation fails
     */
    public function issueSSL(Domain $domain): object
    {
        if (! $domain->is_verified) {
            throw new Exception('Domain must be verified before issuing an SSL certificate.');
        }

        try {
            $domainName = $domain->name;
            $certbotMail = config('app.certbot_mail');
            $foundARecord = false;
            $foundCNAMERecord = false;

            $dns = new Dns;
            $records = $dns->useNameserver('8.8.8.8')->getRecords($domain->name, 'A');

            foreach ($records as $record) {
                // Ensure the record is an instance of A and has the expected properties
                if (! $record instanceof A) {
                    continue;
                }

                if ($record->type() === 'A' && $record->ip() === config('app.ip')) {
                    $foundARecord = true;
                    break;
                }
            }

            if (! $foundARecord) {
                throw new Exception('No valid A record found for the domain. Please ensure the A record added to your domain DNS Setting.');
            }

            $CNAMERecords = $dns->useNameserver('8.8.8.8')->getRecords('www.'.$domain->name, 'CNAME');
            foreach ($CNAMERecords as $record) {
                // Ensure the record is an instance of CNAME and has the expected properties
                if (! $record instanceof CNAME) {
                    continue;
                }

                // Check if the CNAME record points to the domain name
                if ($record->type() === 'CNAME' && $record->target() === $domain->name) {
                    $foundCNAMERecord = true;
                    break;
                }
            }

            if (! $foundCNAMERecord) {
                throw new Exception('No valid CNAME record found for the domain. Please ensure the CNAME record added to your domain DNS Setting.');
            }

            $process = Process::run("sudo /usr/local/bin/deploy-domain.sh {$certbotMail} {$domainName}");

            if ($process->successful()) {
                // Update domain with successful SSL issuance
                $domain->update([
                    'ssl_status' => SslStatusEnum::SUCCESS,
                    'ssl_issued_at' => now(),
                ]);

                return (object) [
                    'status' => true,
                    'message' => "SSL certificate issued successfully for {$domain->name}",
                ];
            } else {
                // Log the error and update domain with failure
                $errorOutput = $process->errorOutput();

                $domain->update([
                    'ssl_status' => SslStatusEnum::FAILED,
                    'ssl_error_log' => $errorOutput,
                ]);

                Log::error('Failed to issue SSL certificate'.$errorOutput);
                throw new Exception('Failed to issue SSL certificate');
            }
        } catch (Exception $e) {
            $domain->update([
                'ssl_status' => SslStatusEnum::FAILED,
                'ssl_error_log' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Download and cache the public suffix list for 24 hours
     */
    public function getPublicSuffixList(): string
    {
        return Cache::remember('public-suffix-list', 60 * 24, function () {
            $response = Http::get(ResourceUri::PUBLIC_SUFFIX_LIST_URI);

            if ($response->failed()) {
                throw new \RuntimeException('Failed to download public suffix list');
            }

            return $response->body();
        });
    }

    /**
     * Download and cache the top level domain list for 24 hours
     */
    public function getTopLevelDomainList(): string
    {
        return Cache::remember('top-level-domain-list', 60 * 24, function () {
            $response = Http::get(ResourceUri::TOP_LEVEL_DOMAIN_LIST_URI);

            if ($response->failed()) {
                throw new \RuntimeException('Failed to download top level domain list');
            }

            return $response->body();
        });
    }

    /**
     * Get the subdomain from the domain name using the public suffix list
     * This method uses the Pdp(php-domain-parser) library to resolve the domain
     *
     * @throws CannotProcessHost
     */
    public function pdpResolvedDomain(Domain $domain): \Pdp\ResolvedDomainName
    {
        $publicSuffixList = $this->getPublicSuffixList();
        $rules = Rules::fromString($publicSuffixList);

        $pdpDomain = \Pdp\Domain::fromIDNA2008($domain->name);

        return $rules->resolve($pdpDomain);
    }
}
