<?php

declare(strict_types=1);

use App\Models\Link;
use App\Models\Product;
use App\Models\User;
use Livewire\Livewire;
use App\Livewire\UserProfile;

beforeEach(function () {
    $this->user = User::factory()->create(['username' => 'testuser']);

    // Create test products
    $this->product1 = Product::factory()->create([
        'user_id' => $this->user->id,
        'name' => 'Laravel Framework Book',
        'description' => 'A comprehensive guide to Laravel development',
        'is_active' => true,
    ]);

    $this->product2 = Product::factory()->create([
        'user_id' => $this->user->id,
        'name' => 'Vue.js Tutorial',
        'description' => 'Learn Vue.js from scratch',
        'is_active' => true,
    ]);

    // Create test links
    $this->link1 = Link::factory()->create([
        'user_id' => $this->user->id,
        'title' => 'Laravel Documentation',
        'description' => 'Official Laravel framework documentation',
        'url' => 'https://laravel.com/docs',
        'is_active' => true,
    ]);

    $this->link2 = Link::factory()->create([
        'user_id' => $this->user->id,
        'title' => 'Vue.js Guide',
        'description' => 'Complete Vue.js learning resource',
        'url' => 'https://vuejs.org/guide',
        'is_active' => true,
    ]);
});

test('user profile displays all products and links when no search is applied', function () {
    Livewire::test(UserProfile::class, ['username' => $this->user->username])
        ->assertSee($this->product1->name)
        ->assertSee($this->product2->name)
        ->assertSee($this->link1->title)
        ->assertSee($this->link2->title);
});

test('product search filters by product name', function () {
    Livewire::test(UserProfile::class, ['username' => $this->user->username])
        ->set('productSearch', 'Laravel')
        ->assertSee($this->product1->name)
        ->assertDontSee($this->product2->name);
});

test('product search filters by product description', function () {
    Livewire::test(UserProfile::class, ['username' => $this->user->username])
        ->set('productSearch', 'comprehensive')
        ->assertSee($this->product1->name)
        ->assertDontSee($this->product2->name);
});

test('link search filters by link title', function () {
    Livewire::test(UserProfile::class, ['username' => $this->user->username])
        ->set('linkSearch', 'Laravel')
        ->assertSee($this->link1->title)
        ->assertDontSee($this->link2->title);
});

test('link search filters by link description', function () {
    Livewire::test(UserProfile::class, ['username' => $this->user->username])
        ->set('linkSearch', 'Official')
        ->assertSee($this->link1->title)
        ->assertDontSee($this->link2->title);
});

test('link search filters by url', function () {
    Livewire::test(UserProfile::class, ['username' => $this->user->username])
        ->set('linkSearch', 'laravel.com')
        ->assertSee($this->link1->title)
        ->assertDontSee($this->link2->title);
});

test('search is case insensitive', function () {
    Livewire::test(UserProfile::class, ['username' => $this->user->username])
        ->set('productSearch', 'LARAVEL')
        ->assertSee($this->product1->name)
        ->assertDontSee($this->product2->name);
});

test('search resets pagination when product search is updated', function () {
    $component = Livewire::test(UserProfile::class, ['username' => $this->user->username]);

    $component->set('productSearch', 'Laravel');

    // Verify that pagination was reset
    expect($component->get('paginators.products_page'))->toBe(1);
});

test('search resets pagination when link search is updated', function () {
    $component = Livewire::test(UserProfile::class, ['username' => $this->user->username]);

    $component->set('linkSearch', 'Laravel');

    // Verify that pagination was reset
    expect($component->get('paginators.links_page'))->toBe(1);
});

test('empty search shows all results', function () {
    Livewire::test(UserProfile::class, ['username' => $this->user->username])
        ->set('productSearch', 'Laravel')
        ->assertSee($this->product1->name)
        ->assertDontSee($this->product2->name)
        ->set('productSearch', '')
        ->assertSee($this->product1->name)
        ->assertSee($this->product2->name);
});
