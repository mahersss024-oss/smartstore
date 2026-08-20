<div>
    <main class="flex-1">
        <!-- Hero Section -->
        <section
            class="py-20 md:py-28 relative overflow-hidden bg-gradient-to-b from-white via-zinc-50/50 to-zinc-100 dark:from-zinc-900 dark:via-zinc-800/50 dark:to-zinc-800">
            <div class="absolute inset-0 bg-grid-zinc-900/[0.02] -z-10"></div>
            <div class="absolute inset-0 flex items-center justify-center -z-10">
                <div class="w-[40rem] h-[40rem] rounded-full bg-accent/5 blur-3xl"></div>
            </div>
            <div class="container mx-auto px-4 md:px-6">
                <div class="grid gap-6 lg:grid-cols-2 lg:gap-12 items-center">
                    <div class="flex flex-col justify-center space-y-4">
                        <div
                            class="inline-flex items-center rounded-full border border-accent/20 px-2.5 py-0.5 text-xs font-semibold bg-accent text-accent-foreground hover:bg-accent/90 w-fit mb-2">
                            <svg class="mr-1 h-3 w-3 text-accent-foreground" fill="none" stroke="currentColor"
                                 stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Built for Creators
                        </div>
                        <div class="space-y-2">
                            <h1 class="text-4xl font-bold tracking-tighter sm:text-5xl xl:text-6xl/none text-foreground">
                                Turn Your <span class="text-accent">Recommendations</span> Into Revenue
                            </h1>
                            <p class="max-w-[600px] text-muted-foreground md:text-xl">
                                The all-in-one platform for creators to showcase products they love and earn through
                                affiliate marketing, all in one beautiful storefront.
                            </p>
                        </div>
                        <div class="flex flex-col gap-2 sm:flex-row">
                            <a href="{{ route('register') }}">
                                <button
                                    class="w-full min-[400px]:w-auto gap-1.5 rounded-full px-5 py-2 bg-accent hover:bg-accent/90 text-accent-foreground text-base font-medium flex items-center justify-center">
                                    Become a Shelf Curator
                                    <svg class="h-4 w-4 ml-2" fill="none" stroke="currentColor" stroke-width="2"
                                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </button>
                            </a>
                            <a href="#how-it-works">
                                <button
                                    class="w-full min-[400px]:w-auto rounded-full border border-muted text-muted-foreground hover:bg-muted px-5 py-2 text-base font-medium">
                                    See How It Works
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="flex justify-center lg:justify-end mt-8 lg:mt-0">
                        <div class="relative w-full max-w-[500px] aspect-square">
                            <div
                                class="absolute inset-0 rounded-2xl bg-gradient-to-br from-accent/20 to-muted rotate-6"></div>
                            <img src="{{ asset('images/hero-image.webp') }}" alt="ShelfCurator Dashboard Preview"
                                 width="500" height="500"
                                 class="relative rounded-2xl shadow-xl border border-muted object-cover z-10"/>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Divider -->
        <div class="relative h-1 bg-gradient-to-r from-transparent via-accent/20 to-transparent"></div>

        <!-- How It Works Section -->
        <section id="how-it-works"
                 class="py-20 bg-gradient-to-b from-zinc-100 via-zinc-50/50 to-white dark:from-zinc-800 dark:via-zinc-800/50 dark:to-zinc-900">
            <div class="max-w-6xl mx-auto px-4 md:px-6">
                <div class="flex flex-col items-center justify-center space-y-4 text-center mb-12">
                    <div
                        class="inline-flex items-center rounded-full border border-accent/20 px-2.5 py-0.5 text-xs font-semibold bg-accent/10 text-accent w-fit">
                        Simple Process
                    </div>
                    <div class="space-y-2">
                        <h2 class="text-3xl font-bold tracking-tighter sm:text-4xl md:text-5xl text-foreground">How
                            ShelfCurator Works</h2>
                        <p class="max-w-[900px] text-muted-foreground md:text-xl/relaxed lg:text-base/relaxed xl:text-xl/relaxed">
                            Get started in three simple steps</p>
                    </div>
                </div>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="relative flex flex-col items-center text-center">
                        <div
                            class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 rounded-full bg-accent text-accent-foreground text-xl font-bold h-10 w-10 flex items-center justify-center">
                            1
                        </div>
                        <div class="rounded-xl border border-muted p-6 pt-10 shadow-sm bg-background h-full">
                            <h3 class="text-xl font-bold mb-2 text-foreground">Create Your Account</h3>
                            <p class="text-muted-foreground">
                                Sign up for ShelfCurator and set up your store with your
                                branding, social media links, and custom domain.
                            </p>
                        </div>
                    </div>
                    <div class="relative flex flex-col items-center text-center">
                        <div
                            class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 rounded-full bg-accent text-accent-foreground text-xl font-bold h-10 w-10 flex items-center justify-center">
                            2
                        </div>
                        <div class="rounded-xl border border-muted p-6 pt-10 shadow-sm bg-background h-full">
                            <h3 class="text-xl font-bold mb-2 text-foreground">Add Your Products</h3>
                            <p class="text-muted-foreground">
                                Add products you love with descriptions, images, and your
                                affiliate links from your affiliate partners.
                            </p>
                        </div>
                    </div>
                    <div class="relative flex flex-col items-center text-center">
                        <div
                            class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 rounded-full bg-accent text-accent-foreground text-xl font-bold h-10 w-10 flex items-center justify-center">
                            3
                        </div>
                        <div class="rounded-xl border border-muted p-6 pt-10 shadow-sm bg-background h-full">
                            <h3 class="text-xl font-bold mb-2 text-foreground">Share & Earn</h3>
                            <p class="text-muted-foreground">
                                Share your ShelfCurator profile and earn commissions when your audience shops through your links.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Divider -->
        <div class="relative h-1 bg-gradient-to-r from-transparent via-accent/20 to-transparent"></div>

        <!-- Features Section -->
        <section id="features"
                 class="py-20 bg-gradient-to-b from-white via-zinc-50/50 to-zinc-100 dark:from-zinc-900 dark:via-zinc-800/50 dark:to-zinc-800">
            <div class="max-w-6xl mx-auto px-4 md:px-6">
                <div class="flex flex-col items-center justify-center space-y-4 text-center mb-12">
                    <div
                        class="inline-flex items-center rounded-full border border-accent/20 px-2.5 py-0.5 text-xs font-semibold bg-accent/10 text-accent w-fit">
                        Everything You Need
                    </div>
                    <div class="space-y-2">
                        <h2 class="text-3xl font-bold tracking-tighter sm:text-4xl md:text-5xl text-foreground">
                            Everything You Need in One Place</h2>
                        <p class="max-w-[900px] text-muted-foreground md:text-xl/relaxed lg:text-base/relaxed xl:text-xl/relaxed">
                            ShelfCurator provides all the tools you need to manage your product recommendations and
                            maximize your earnings.</p>
                    </div>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-12">
                    <div class="relative flex flex-col items-center text-center">
                        <div
                            class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 rounded-full bg-accent text-accent-foreground text-xl font-bold h-10 w-10 flex items-center justify-center">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24">
                                <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                                <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                            </svg>
                        </div>
                        <div class="rounded-xl border border-muted p-6 pt-10 shadow-sm bg-background h-full">
                            <h3 class="text-xl font-bold mb-2 text-foreground">Affiliate Link Management</h3>
                            <p class="text-muted-foreground">Easily organize and track all your affiliate links
                                in one centralized dashboard with advanced analytics.</p>
                        </div>
                    </div>
                    <div class="relative flex flex-col items-center text-center">
                        <div
                            class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 rounded-full bg-accent text-accent-foreground text-xl font-bold h-10 w-10 flex items-center justify-center">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24">
                                <rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect>
                                <line x1="3" x2="21" y1="9" y2="9"></line>
                                <line x1="9" x2="9" y1="21" y2="9"></line>
                            </svg>
                        </div>
                        <div class="rounded-xl border border-muted p-6 pt-10 shadow-sm bg-background h-full">
                            <h3 class="text-xl font-bold mb-2 text-foreground">Intuitive Dashboard</h3>
                            <p class="text-muted-foreground">Get comprehensive insights on clicks, conversions,
                                and earnings with our easy-to-use analytics dashboard.</p>
                        </div>
                    </div>
                    <div class="relative flex flex-col items-center text-center">
                        <div
                            class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 rounded-full bg-accent text-accent-foreground text-xl font-bold h-10 w-10 flex items-center justify-center">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                <path d="M2 12h20"></path>
                            </svg>
                        </div>
                        <div class="rounded-xl border border-muted p-6 pt-10 shadow-sm bg-background h-full">
                            <h3 class="text-xl font-bold mb-2 text-foreground">Custom Storefront</h3>
                            <p class="text-muted-foreground">Create a beautiful, branded page to showcase all
                                your recommended products with custom domains.</p>
                        </div>
                    </div>
                    <div class="relative flex flex-col items-center text-center">
                        <div
                            class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 rounded-full bg-accent text-accent-foreground text-xl font-bold h-10 w-10 flex items-center justify-center">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24">
                                <path d="M3 3v18h18"></path>
                                <path d="M7 12l3-3 3 3 5-5"></path>
                                <circle cx="7" cy="12" r="1"></circle>
                                <circle cx="10" cy="9" r="1"></circle>
                                <circle cx="13" cy="12" r="1"></circle>
                                <circle cx="18" cy="7" r="1"></circle>
                            </svg>
                        </div>
                        <div class="rounded-xl border border-muted p-6 pt-10 shadow-sm bg-background h-full">
                            <h3 class="text-xl font-bold mb-2 text-foreground">Advanced Analytics</h3>
                            <p class="text-muted-foreground">Track performance metrics, conversion rates, and
                                revenue insights to optimize your recommendations.</p>
                        </div>
                    </div>
                    <div class="relative flex flex-col items-center text-center">
                        <div
                            class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 rounded-full bg-accent text-accent-foreground text-xl font-bold h-10 w-10 flex items-center justify-center">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                <path d="M2 12h20"></path>
                            </svg>
                        </div>
                        <div class="rounded-xl border border-muted p-6 pt-10 shadow-sm bg-background h-full">
                            <h3 class="text-xl font-bold mb-2 text-foreground">Audience Insights</h3>
                            <p class="text-muted-foreground">Understand your audience better with detailed
                                demographics and engagement analytics.</p>
                        </div>
                    </div>
                    <div class="relative flex flex-col items-center text-center">
                        <div
                            class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 rounded-full bg-accent text-accent-foreground text-xl font-bold h-10 w-10 flex items-center justify-center">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24">
                                <path d="m15 14 5-5-5-5"></path>
                                <path d="M20 9H9.5a3.5 3.5 0 0 0 0 7h.5"></path>
                            </svg>
                        </div>
                        <div class="rounded-xl border border-muted p-6 pt-10 shadow-sm bg-background h-full">
                            <h3 class="text-xl font-bold mb-2 text-foreground">Quick Setup</h3>
                            <p class="text-muted-foreground">Get your store up and running in minutes with our
                                streamlined onboarding process.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Divider -->
        <div class="relative h-1 bg-gradient-to-r from-transparent via-accent/20 to-transparent"></div>

        <!-- Benefits Section -->
        <section id="benefits"
                 class="py-20 bg-gradient-to-b from-zinc-100 via-zinc-50/50 to-white dark:from-zinc-800 dark:via-zinc-800/50 dark:to-zinc-900">
            <div class="max-w-6xl mx-auto px-4 md:px-6">
                <div class="flex flex-col items-center justify-center space-y-4 text-center mb-12">
                    <div
                        class="inline-flex items-center rounded-full border border-accent/20 px-2.5 py-0.5 text-xs font-semibold bg-accent/10 text-accent w-fit">
                        Creator Benefits
                    </div>
                    <div class="space-y-2">
                        <h2 class="text-3xl font-bold tracking-tighter sm:text-4xl md:text-5xl text-foreground">Benefits
                            for Influencers</h2>
                        <p class="max-w-[900px] text-muted-foreground md:text-xl/relaxed lg:text-base/relaxed xl:text-xl/relaxed">
                            Join thousands of creators who are maximizing their influence and income with
                            ShelfCurator.</p>
                    </div>
                </div>
                <div class="mx-auto grid max-w-6xl grid-cols-1 gap-8 md:grid-cols-2">
                    <div class="flex items-start gap-4">
                        <svg class="mt-1 h-6 w-6 text-accent flex-shrink-0" fill="none" stroke="currentColor"
                             stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 12l2 2l4-4"></path>
                            <circle cx="12" cy="12" r="10"></circle>
                        </svg>
                        <div>
                            <h3 class="text-xl font-bold text-foreground">Earn More with Affiliate Links</h3>
                            <p class="text-muted-foreground">Maximize your revenue by organizing all your affiliate
                                partnerships in one place with easy tracking.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <svg class="mt-1 h-6 w-6 text-accent flex-shrink-0" fill="none" stroke="currentColor"
                             stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 12l2 2l4-4"></path>
                            <circle cx="12" cy="12" r="10"></circle>
                        </svg>
                        <div>
                            <h3 class="text-xl font-bold text-foreground">Centralized Management</h3>
                            <p class="text-muted-foreground">Save time by managing all your product recommendations from
                                a single dashboard.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <svg class="mt-1 h-6 w-6 text-accent flex-shrink-0" fill="none" stroke="currentColor"
                             stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 12l2 2l4-4"></path>
                            <circle cx="12" cy="12" r="10"></circle>
                        </svg>
                        <div>
                            <h3 class="text-xl font-bold text-foreground">Professional Storefront</h3>
                            <p class="text-muted-foreground">Impress your audience with a beautifully designed, branded
                                product showcase page.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <svg class="mt-1 h-6 w-6 text-accent flex-shrink-0" fill="none" stroke="currentColor"
                             stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 12l2 2l4-4"></path>
                            <circle cx="12" cy="12" r="10"></circle>
                        </svg>
                        <div>
                            <h3 class="text-xl font-bold text-foreground">Data-Driven Decisions</h3>
                            <p class="text-muted-foreground">Use analytics to understand which products resonate with
                                your audience and optimize your recommendations.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Divider -->
        <div class="relative h-1 bg-gradient-to-r from-transparent via-accent/20 to-transparent"></div>

        <!-- Testimonials Section -->
        <section id="testimonials"
                 class="py-20 bg-gradient-to-b from-white via-zinc-50/50 to-zinc-100 dark:from-zinc-900 dark:via-zinc-800/50 dark:to-zinc-800">
            <div class="max-w-6xl mx-auto px-4 md:px-6">
                <div class="flex flex-col items-center justify-center space-y-4 text-center mb-12">
                    <div
                        class="inline-flex items-center rounded-full border border-accent/20 px-2.5 py-0.5 text-xs font-semibold bg-accent/10 text-accent w-fit">
                        Success Stories
                    </div>
                    <div class="space-y-2">
                        <h2 class="text-3xl font-bold tracking-tighter sm:text-4xl md:text-5xl text-foreground">Loved by
                            Creators</h2>
                        <p class="max-w-[900px] text-muted-foreground md:text-xl/relaxed lg:text-base/relaxed xl:text-xl/relaxed">
                            See what influencers and content creators are saying about ShelfCurator.</p>
                    </div>
                </div>
                <div class="mx-auto grid max-w-6xl grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <div
                        class="flex flex-col justify-between rounded-xl border border-muted bg-background p-6 shadow-sm hover:shadow-lg transition-shadow">
                        <div class="space-y-4">
                            <div class="flex gap-1">
                                @for ($i = 0; $i < 5; $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                         class="w-5 h-5 text-yellow-500">
                                        <path fill-rule="evenodd"
                                              d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                @endfor
                            </div>
                            <p class="text-muted-foreground">"ShelfCurator has completely transformed how I manage my
                                product recommendations. My audience loves the clean storefront, and I've seen a 30%
                                increase in affiliate revenue."</p>
                        </div>
                        <div class="flex items-center gap-4 pt-4">
                            <div
                                class="w-10 h-10 flex items-center justify-center bg-zinc-200 relative rounded-full border border-accent shadow-xl">
                                <flux:icon name="user" class="w-4 h-4 text-gray-400"/>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-foreground">Sarah J.</p>
                                <p class="text-xs text-muted-foreground">Lifestyle Blogger</p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex flex-col justify-between rounded-xl border border-muted bg-background p-6 shadow-sm hover:shadow-lg transition-shadow">
                        <div class="space-y-4">
                            <div class="flex gap-1">
                                @for ($i = 0; $i < 5; $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                         class="w-5 h-5 text-yellow-500">
                                        <path fill-rule="evenodd"
                                              d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                @endfor
                            </div>
                            <p class="text-muted-foreground">"The analytics dashboard is a game-changer. I can finally
                                see which products my followers are actually interested in and focus my content
                                accordingly."</p>
                        </div>
                        <div class="flex items-center gap-4 pt-4">
                            <div
                                class="w-10 h-10 flex items-center justify-center bg-zinc-200 relative rounded-full border border-accent shadow-xl">
                                <flux:icon name="user" class="w-4 h-4 text-gray-400"/>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-foreground">Marcus T.</p>
                                <p class="text-xs text-muted-foreground">Tech Reviewer</p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex flex-col justify-between rounded-xl border border-muted bg-background p-6 shadow-sm hover:shadow-lg transition-shadow md:col-span-2 lg:col-span-1">
                        <div class="space-y-4">
                            <div class="flex gap-1">
                                @for ($i = 0; $i < 5; $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                         class="w-5 h-5 text-yellow-500">
                                        <path fill-rule="evenodd"
                                              d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                @endfor
                            </div>
                            <p class="text-muted-foreground">"Setting up my storefront took minutes, not hours. Now I
                                have a professional-looking page for all my beauty recommendations that I can share with
                                my followers."</p>
                        </div>
                        <div class="flex items-center gap-4 pt-4">
                            <div
                                class="w-10 h-10 flex items-center justify-center bg-zinc-200 relative rounded-full border border-accent shadow-xl">
                                <flux:icon name="user" class="w-4 h-4 text-gray-400"/>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-foreground">Aisha K.</p>
                                <p class="text-xs text-muted-foreground">Beauty Influencer</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="relative h-1 bg-gradient-to-r from-transparent via-accent/20 to-transparent"></div>
        <!-- CTA Section -->
        <section
            class="py-20 bg-gradient-to-b from-zinc-100 via-zinc-50/50 to-white dark:from-zinc-800 dark:via-zinc-800/50 dark:to-zinc-900">
            <div class="max-w-6xl mx-auto px-4 md:px-6">
                <div
                    class="relative overflow-hidden rounded-3xl px-6 py-16 sm:px-12 sm:py-20 md:py-30 lg:px-20 bg-gradient-to-r from-transparent via-accent/20 to-transparent">
                    <div
                        class="absolute inset-0 bg-grid-white/10 dark:bg-grid-zinc-700/10 [mask-image:radial-gradient(white,transparent_70%)]"></div>
                    <div class="relative flex flex-col items-center justify-center space-y-4 text-center">
                        <div class="space-y-2">
                            <h2 class="text-3xl font-bold tracking-tighter sm:text-4xl md:text-5xl text-foreground">
                                Ready to Curate Your Shelf?</h2>
                            <p class="max-w-[600px] text-muted-foreground md:text-xl/relaxed lg:text-base/relaxed xl:text-xl/relaxed">
                                Join thousands of creators who are growing their influence and income with
                                ShelfCurator.</p>
                        </div>
                        <div class="flex flex-col gap-2 min-[400px]:flex-row">
                            <a href="{{ route('register') }}">
                                <button
                                    class="w-full min-[400px]:w-auto gap-1.5 rounded-full px-5 py-2 bg-accent hover:bg-accent/90 text-accent-foreground text-base font-medium flex items-center justify-center">
                                    Become a Shelf Curator
                                    <svg class="h-4 w-4 ml-2" fill="none" stroke="currentColor" stroke-width="2"
                                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>

