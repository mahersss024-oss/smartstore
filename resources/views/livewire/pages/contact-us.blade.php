<div class="min-h-screen bg-gradient-to-b from-white via-zinc-50/50 to-zinc-100 dark:from-zinc-900 dark:via-zinc-800/50 dark:to-zinc-800">
    <div class="container mx-auto px-4 md:px-6 py-20">
        <div class="max-w-6xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center rounded-full border border-accent/20 px-2.5 py-0.5 text-xs font-semibold bg-accent/10 text-accent w-fit mb-4">
                    Get in Touch
                </div>
                <h1 class="text-3xl font-bold tracking-tighter sm:text-4xl md:text-5xl text-foreground mb-4">
                    Contact Information
                </h1>
                <p class="text-muted-foreground text-sm">
                    Last updated on {{ \Illuminate\Support\Carbon::parse('2025-07-22')->format('d-M-Y') }}
                </p>
            </div>

            <!-- Contact Form -->
            <div class="max-w-lg mx-auto p-8 rounded-xl border shadow-sm">
                <h2 class="text-xl font-bold text-foreground mb-6">Get in Touch</h2>
                <div class="space-y-4">
                    <p>Have a question or need help? We're here to assist you. Send us a message and we'll get back to you as soon as possible.</p>
                    <div class="flex items-start gap-4">
                        <div class="rounded-full bg-accent/10 p-2">
                            <svg class="h-5 w-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M21 8.5l-9 5.5-9-5.5M3 6h18c1.1 0 2 .9 2 2v8c0 1.1-.9 2-2 2H3c-1.1 0-2-.9-2-2V8c0-1.1.9-2 2-2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium text-foreground">Email</h3>
                            <p class="text-muted-foreground">support@shelfcurator.com</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="rounded-full bg-accent/10 p-2">
                            <svg class="h-5 w-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                                <circle cx="12" cy="9" r="2.5"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium text-foreground">Response Time</h3>
                            <p class="text-muted-foreground">We typically respond within 24 hours</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="rounded-full bg-accent/10 p-2">
                            <svg class="h-5 w-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12,6 12,12 16,14"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium text-foreground">Business Hours</h3>
                            <p class="text-muted-foreground">Monday - Friday, 9 AM - 6 PM IST</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
