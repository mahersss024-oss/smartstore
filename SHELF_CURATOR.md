# ShelfCurator

ShelfCurator is an all-in-one platform for creators to showcase affiliate products they love and earn through affiliate marketing, all in one beautiful storefront.

## Project Functionality

### Authentication

- Login (`/login`)->name(`login`)
- Registration (`/register`)->name(`register`)
- Password reset request (`/forgot-password`)->name(`password.request`)
- Password reset (`/reset-password/{token}`)->name(`password.reset`)
- Email verification notice (`/verify-email`)->name(`verification.notice`)
- Verify email (signed) (`/verify-email/{id}/{hash}`)->name(`verification.verify`)
- Confirm password (`/confirm-password`)->name(`password.confirm`)

### Public Pages

1. Home Page ([`/`](app/Livewire/Home.php))->name(`home`)
   - Landing page for all visitors
   - Highlights features and provides auth entry points

2. Pricing ([`/pricing`](app/Livewire/Pages/Pricing.php))->name(`pages.pricing`)

3. Contact Us ([`/contact-us`](app/Livewire/Pages/ContactUs.php))->name(`pages.contact-us`)

4. Terms & Conditions ([`/terms-and-conditions`](app/Livewire/Pages/TermsAndConditions.php))->name(`pages.terms-and-conditions`)

5. Privacy Policy ([`/privacy-policy`](app/Livewire/Pages/PrivacyPolicy.php))->name(`pages.privacy-policy`)

6. Refund Policy ([`/refund-policy`](app/Livewire/Pages/RefundPolicy.php))->name(`pages.refund-policy`)

7. User Profile ([`/{username}`](app/Livewire/UserProfile.php))->name(`user.profile`)
   - Public storefront for each creator
   - Shows display name, bio, profile image, products, and custom links
   - Username supports letters, numbers, `_` and `-`
   - Custom domain support if configured

### Dashboard Area (Authenticated Users)

1. Dashboard ([`/dashboard`](app/Livewire/Dashboard.php))->name(`dashboard`)
   - Overview cards and quick actions
   - Subscription plan section with manage/upgrade actions

2. Products ([`/products`](app/Livewire/Products/ProductsIndex.php))->name(`products.index`)
   - Manage product catalog and affiliate links

3. Links ([`/links`](app/Livewire/Links/LinksIndex.php))->name(`links.index`)
   - Manage custom links shown on the profile storefront

4. Social Icons ([`/social-icons`](app/Livewire/SocialIconsIndex.php))->name(`social-icons.index`)
   - Manage social icon platforms and URLs

5. **Settings**

   a. **Profile Settings** ([`/settings/profile`](app/Livewire/Settings/ProfileSettings.php))->name(`settings.profile`)
    - Update username, display name, bio, logo

   b. **Domain Settings** ([`/settings/domain`](app/Livewire/Settings/DomainSettings.php))->name(`settings.domain`)
    - Add custom domain
    - DNS Configuration Steps:
        1. Add TXT record for domain verification
        2. Configure A record for domain pointing
        3. Set up CNAME record for subdomain support
    - Domain verification system
    - View domain status

   c. **Account Settings** ([`/settings/account`](app/Livewire/Settings/Account.php))->name(`settings.account`)
    - Update name and email

   d. **Password Management** ([`/settings/password`](app/Livewire/Settings/Password.php))->name(`settings.password`)
    - update password

   e. **Appearance Settings** ([`/settings/appearance`](app/Livewire/Settings/Appearance.php))->name(`settings.appearance`)
    - Toggle light and dark mode

### Admin Area (super-admin)

1. User Management ([`/admin/users`](app/Livewire/Admin/Users/UsersIndex.php))->name(`admin.users.index`)
    - View all users
    - Search users by name or email

2. Promotions ([`/admin/promotions`](app/Livewire/Admin/Promotion/PromotionIndex.php))->name(`admin.promotions.index`)
    - Send promotional emails to users
