<section class="w-full">
    <x-page-header
        :title="__('Settings')"
        :description="__('Manage your store settings and preferences')"
    />

    <x-settings.layout
        :heading="__('Domain Settings')"
        :subheading="__('Connect a custom domain to your store')"
    >
        @if(!auth()->user()->subscribed())
            <flux:callout icon="exclamation-circle" color="red" class="mb-4" inline="true">
                <flux:callout.heading>You need to subscribe plan to connect your domain.</flux:callout.heading>
                <x-slot name="actions">
                    <flux:button href="{{ route('pages.pricing') }}">Check Pricing</flux:button>
                </x-slot>
            </flux:callout>
        @endif

        @if (session('message'))
            <flux:alert type="success" class="mb-4">{{ session('message') }}</flux:alert>
        @endif
        @if (session('error'))
            <flux:alert type="warning" class="mb-4">{{ session('error') }}</flux:alert>
        @endif

        <form wire:submit="save">
            <!-- Custom Domain -->
            <flux:field>
                <flux:label>Custom Domain</flux:label>
                <flux:input wire:model.defer="name" placeholder="yourdomain.com"/>
                <flux:description class="mt-1!">Enter your domain without http:// or https://</flux:description>
                <flux:error field="name"/>
            </flux:field>

            <flux:button type="submit" variant="primary" class="mt-6">Save Domain Settings</flux:button>
        </form>

        @if ($domain)
            <flux:separator class="my-6"/>

            <div class="mb-4">
                <flux:heading size="lg">Domain Verification</flux:heading>
                <flux:text class="mt-2">To verify your domain, add the following records to your domain's DNS settings
                </flux:text>
            </div>

            <flux:table>
                <flux:table.columns>
                    <flux:table.column>Type</flux:table.column>
                    <flux:table.column>Name</flux:table.column>
                    <flux:table.column>Value</flux:table.column>
                </flux:table.columns>
                <flux:table.rows>
                    <flux:table.row>
                        <flux:table.cell>TXT</flux:table.cell>
                        <flux:table.cell>
                            <flux:input :value="$this->subDomain ?? '@'" readonly copyable/>
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:input :value="$domain->verification_token" readonly copyable/>
                        </flux:table.cell>
                    </flux:table.row>
                    <flux:table.row>
                        <flux:table.cell>A</flux:table.cell>
                        <flux:table.cell>
                            <flux:input :value="$this->subDomain ?? '@'" readonly copyable/>
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:input :value="config('app.ip', 'YOUR_SERVER_IP')" readonly copyable/>
                        </flux:table.cell>
                    </flux:table.row>
                    <flux:table.row>
                        <flux:table.cell>CNAME</flux:table.cell>
                        <flux:table.cell>
                            <flux:input :value="$this->subDomain ? 'www.' . $this->subDomain : 'www'" readonly copyable/>
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:input :value="$this->domain->name" readonly copyable/>
                        </flux:table.cell>
                    </flux:table.row>
                </flux:table.rows>
            </flux:table>

            @if($domain->is_verified)
                <div class="mt-4">
                    <p class="mt-2 text-green-600 dark:text-green-400">
                        <svg class="inline-block w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        Domain is verified
                    </p>
                    <flux:description class="!mt-1">
                        Verified at: {{ $domain->verified_at->format('M d, Y H:i') }}
                    </flux:description>

                    <!-- SSL Certificate Section -->
                    <div class="mt-6">
                        <h4 class="text-md font-medium leading-6 text-gray-900 dark:text-white">SSL Certificate</h4>

                        @if($domain->ssl_status === \App\Enums\Domain\SslStatusEnum::SUCCESS)
                            <p class="mt-2 text-green-600 dark:text-green-400">
                                <svg class="inline-block w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                          clip-rule="evenodd"></path>
                                </svg>
                                SSL certificate is active
                            </p>
                            <flux:description class="!mt-1">
                                Issued at: {{ $domain->ssl_issued_at->format('M d, Y H:i') }}
                            </flux:description>
                        @elseif($domain->ssl_status === \App\Enums\Domain\SslStatusEnum::PENDING)
                            <p class="mt-2 text-yellow-600 dark:text-yellow-400">
                                <svg class="inline-block w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                          clip-rule="evenodd"></path>
                                </svg>
                                SSL certificate issuance in progress...
                            </p>
                        @elseif($domain->ssl_status === \App\Enums\Domain\SslStatusEnum::FAILED)
                            <p class="mt-2 text-red-600 dark:text-red-400">
                                <svg class="inline-block w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                          clip-rule="evenodd"></path>
                                </svg>
                                SSL certificate issuance failed
                            </p>
                        @else
                            <p class="mt-2 text-gray-600 dark:text-gray-400">
                                No SSL certificate has been issued yet.
                            </p>
                        @endif
                    </div>
                </div>
            @endif

            @if($domain->ssl_status === \App\Enums\Domain\SslStatusEnum::PENDING || $domain->ssl_status === \App\Enums\Domain\SslStatusEnum::FAILED)
                <flux:button wire:click="verifyDomain" variant="primary" class="mt-4">
                    {{ $domain->ssl_status === \App\Enums\Domain\SslStatusEnum::PENDING ? 'Verify Domain' : 'Try Again' }}
                </flux:button>
            @endif
        @endif

    </x-settings.layout>
</section>
