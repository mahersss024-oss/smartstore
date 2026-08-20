<?php

use App\Livewire\Admin\Users\UsersIndex;
use App\Livewire\Dashboard;
use App\Livewire\Home;
use App\Livewire\Links\LinksIndex;
use App\Livewire\Pages\ContactUs;
use App\Livewire\Pages\Pricing;
use App\Livewire\Pages\PrivacyPolicy;
use App\Livewire\Pages\RefundPolicy;
use App\Livewire\Pages\TermsAndConditions;
use App\Livewire\Products\ProductsIndex;
use App\Livewire\Settings\Account;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\DomainSettings;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\ProfileSettings;
use App\Livewire\SocialIconsIndex;
use App\Livewire\UserProfile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Promotion\PromotionIndex;

require __DIR__.'/auth.php';

Route::get('/', Home::class)->name('home');

// Public pages
Route::get('/contact-us', ContactUs::class)->name('pages.contact-us');
Route::get('/terms-and-conditions', TermsAndConditions::class)->name('pages.terms-and-conditions');
Route::get('/privacy-policy', PrivacyPolicy::class)->name('pages.privacy-policy');
Route::get('/refund-policy', RefundPolicy::class)->name('pages.refund-policy');
Route::get('/pricing', Pricing::class)->name('pages.pricing');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', Dashboard::class)->name('dashboard');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'role:super-admin'])->group(function () {
    Route::get('users', UsersIndex::class)->name('users.index');
    Route::get('promotions', PromotionIndex::class)->name('promotions.index');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('settings/profile', ProfileSettings::class)->name('settings.profile');
    Route::get('settings/domain', DomainSettings::class)->name('settings.domain');
    Route::get('settings/account', Account::class)->name('settings.account');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::get('products', ProductsIndex::class)->name('products.index');
    Route::get('links', LinksIndex::class)->name('links.index');
    Route::get('social-icons', SocialIconsIndex::class)->name('social-icons.index');
});

Route::get('/{username}', UserProfile::class)
    ->where('username', '[A-Za-z0-9_\-]+')
    ->name('user.profile');
