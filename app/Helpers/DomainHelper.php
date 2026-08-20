<?php

namespace App\Helpers;

use App\Enums\Domain\SslStatusEnum;
use App\Models\Domain;

class DomainHelper
{
    /**
     * Check if the given URL is a valid domain.
     */
    public static function isVerifiedDomain(?Domain $domain): bool
    {
        return $domain?->is_verified && $domain?->ssl_status === SslStatusEnum::SUCCESS;
    }

    /**
     * Get the URL for the given domain.
     */
    public static function getDomainUrl(?Domain $domain, string $username): string
    {
        if (self::isVerifiedDomain($domain) && $domain?->user?->subscribed()) {
            return 'https://'.$domain->name;
        } else {
            return route('user.profile', ['username' => $username]);
        }
    }
}
