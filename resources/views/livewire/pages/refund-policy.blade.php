<div class="min-h-screen bg-gradient-to-b from-white via-zinc-50/50 to-zinc-100 dark:from-zinc-900 dark:via-zinc-800/50 dark:to-zinc-800">
    <div class="container mx-auto px-4 md:px-6 py-20">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center rounded-full border border-accent/20 px-2.5 py-0.5 text-xs font-semibold bg-accent/10 text-accent w-fit mb-4">
                    Policy Information
                </div>
                <h1 class="text-3xl font-bold tracking-tighter sm:text-4xl md:text-5xl text-foreground mb-4">
                    Refund Policy
                </h1>
                <p class="text-muted-foreground text-sm">
                    Last updated on {{ \Illuminate\Support\Carbon::parse('2025-07-22')->format('d-M-Y') }}
                </p>
            </div>

            <!-- Refund Policy Content -->
            <div class="bg-background rounded-xl border border-muted p-4 lg:p-8 shadow-sm">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-red-50 flex items-center justify-center">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="15" y1="9" x2="9" y2="15"/>
                            <line x1="9" y1="9" x2="15" y2="15"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-foreground mb-4">No Refunds Policy</h2>
                    <p class="text-muted-foreground text-lg max-w-2xl mx-auto">
                        We do not provide any refunds for our services.
                    </p>
                </div>

                <div class="space-y-6">
                    <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-red-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.863-.833-2.632 0L4.182 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                            <div>
                                <h3 class="font-semibold text-red-800 mb-2">Important Notice</h3>
                                <p class="text-red-700 leading-relaxed">
                                    All sales are final. Once you have purchased and gained access to our services, no refunds will be provided under any circumstances.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="bg-zinc-50 text-green-600 border border-green-600 rounded-lg p-6">
                            <h3 class="font-semibold text-foreground mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/>
                                </svg>
                                Why No Refunds?
                            </h3>
                            <ul class="space-y-2 text-muted-foreground text-sm">
                                <li class="flex items-start gap-2">
                                    <span class="w-1 h-1 rounded-full bg-accent mt-2 flex-shrink-0"></span>
                                    Digital services are consumed immediately upon access
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="w-1 h-1 rounded-full bg-accent mt-2 flex-shrink-0"></span>
                                    We provide detailed service descriptions before purchase
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="w-1 h-1 rounded-full bg-accent mt-2 flex-shrink-0"></span>
                                    This policy ensures fair pricing for all users
                                </li>
                            </ul>
                        </div>

                        <div class="bg-zinc-50 text-green-600 border border-green-600 rounded-lg p-6">
                            <h3 class="font-semibold text-foreground mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M9 12l2 2l4-4"/>
                                    <circle cx="12" cy="12" r="10"/>
                                </svg>
                                Before You Purchase
                            </h3>
                            <ul class="space-y-2 text-muted-foreground text-sm">
                                <li class="flex items-start gap-2">
                                    <span class="w-1 h-1 rounded-full bg-accent mt-2 flex-shrink-0"></span>
                                    Review all service features and limitations
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="w-1 h-1 rounded-full bg-accent mt-2 flex-shrink-0"></span>
                                    Contact us if you have any questions
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="w-1 h-1 rounded-full bg-accent mt-2 flex-shrink-0"></span>
                                    Ensure the service meets your requirements
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                                <path d="M12 17h.01"/>
                            </svg>
                            <div>
                                <h3 class="font-semibold text-blue-800 mb-2">Have Questions?</h3>
                                <p class="text-blue-700 leading-relaxed mb-3">
                                    If you have any questions about our services or this refund policy, please don't hesitate to contact us before making a purchase.
                                </p>
                                <a href="{{ route('pages.contact-us') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 font-medium">
                                    Contact Support
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M5 12h14"/>
                                        <path d="m12 5 7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-muted text-center">
                    <p class="text-muted-foreground text-sm">
                        By using our services, you acknowledge that you have read and understood this refund policy.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
