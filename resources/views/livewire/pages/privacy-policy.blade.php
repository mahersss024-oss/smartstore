<div class="min-h-screen bg-gradient-to-b from-white via-zinc-50/50 to-zinc-100 dark:from-zinc-900 dark:via-zinc-800/50 dark:to-zinc-800">
    <div class="container mx-auto px-4 md:px-6 py-20">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center rounded-full border border-accent/20 px-2.5 py-0.5 text-xs font-semibold bg-accent/10 text-accent w-fit mb-4">
                    Legal Information
                </div>
                <h1 class="text-3xl font-bold tracking-tighter sm:text-4xl md:text-5xl text-foreground mb-4">
                    Privacy Policy
                </h1>
                <p class="text-muted-foreground text-sm">
                    Last updated on {{ \Illuminate\Support\Carbon::parse('2025-08-06')->format('d-M-Y') }}
                </p>
            </div>

            <!-- Privacy Policy Content -->
            <div class="bg-background rounded-xl border border-muted p-8 shadow-sm">
                <div class="prose prose-zinc max-w-none dark:prose-invert">
                    <p class="text-muted-foreground leading-relaxed mb-6">
                        At ShelfCurator, we respect your privacy and are committed to protecting your personal data. This privacy policy explains how we collect, use, and safeguard your information when you use our platform.
                    </p>

                    <h2 class="text-xl font-semibold text-foreground mb-4 mt-8">Information We Collect</h2>
                    <p class="text-muted-foreground leading-relaxed mb-4">
                        We collect information you provide directly to us, such as when you create an account, update your profile, or contact us for support.
                    </p>
                    <ul class="list-disc list-inside text-muted-foreground leading-relaxed mb-6 space-y-2">
                        <li>Personal information (name, email address, username)</li>
                        <li>Profile information and preferences</li>
                        <li>Product information and recommendations you share</li>
                        <li>Communications with our support team</li>
                    </ul>

                    <h2 class="text-xl font-semibold text-foreground mb-4 mt-8">How We Use Your Information</h2>
                    <p class="text-muted-foreground leading-relaxed mb-4">
                        We use the information we collect to:
                    </p>
                    <ul class="list-disc list-inside text-muted-foreground leading-relaxed mb-6 space-y-2">
                        <li>Provide, maintain, and improve our services</li>
                        <li>Process transactions and send related information</li>
                        <li>Send technical notices and support messages</li>
                        <li>Respond to your comments and questions</li>
                        <li>Protect against fraudulent or illegal activity</li>
                    </ul>

                    <h2 class="text-xl font-semibold text-foreground mb-4 mt-8">Information Sharing</h2>
                    <p class="text-muted-foreground leading-relaxed mb-6">
                        We do not sell, trade, or otherwise transfer your personal information to third parties without your consent, except as described in this policy. We may share your information in the following circumstances:
                    </p>
                    <ul class="list-disc list-inside text-muted-foreground leading-relaxed mb-6 space-y-2">
                        <li>With your explicit consent</li>
                        <li>To comply with legal obligations</li>
                        <li>To protect our rights and prevent fraud</li>
                        <li>In connection with a business transfer</li>
                    </ul>

                    <h2 class="text-xl font-semibold text-foreground mb-4 mt-8">Data Security</h2>
                    <p class="text-muted-foreground leading-relaxed mb-6">
                        We implement appropriate technical and organizational security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.
                    </p>

                    <h2 class="text-xl font-semibold text-foreground mb-4 mt-8">Your Rights</h2>
                    <p class="text-muted-foreground leading-relaxed mb-4">
                        You have the right to:
                    </p>
                    <ul class="list-disc list-inside text-muted-foreground leading-relaxed mb-6 space-y-2">
                        <li>Access and update your personal information</li>
                        <li>Request deletion of your account and data</li>
                        <li>Opt-out of marketing communications</li>
                        <li>Request a copy of your data</li>
                    </ul>

                    <h2 class="text-xl font-semibold text-foreground mb-4 mt-8">Cookies and Tracking</h2>
                    <p class="text-muted-foreground leading-relaxed mb-6">
                        We use cookies and similar tracking technologies to enhance your experience on our platform. You can control cookie preferences through your browser settings.
                    </p>

                    <h2 class="text-xl font-semibold text-foreground mb-4 mt-8">Changes to This Policy</h2>
                    <p class="text-muted-foreground leading-relaxed mb-6">
                        We may update this privacy policy from time to time. We will notify you of any changes by posting the new policy on this page and updating the "Last updated" date.
                    </p>

                    <h2 class="text-xl font-semibold text-foreground mb-4 mt-8">Contact Us</h2>
                    <p class="text-muted-foreground leading-relaxed mb-6">
                        If you have any questions about this privacy policy or our data practices, please contact us through our <a href="{{ route('pages.contact-us') }}" class="text-accent hover:underline">contact page</a>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
