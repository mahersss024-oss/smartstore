<?php

declare(strict_types=1);

use App\Models\Domain;
use App\Models\Link;
use App\Models\Product;
use App\Models\User;
use Livewire\Livewire;
use App\Livewire\Home;

beforeEach(function () {
    $this->user = User::factory()->create(['username' => 'testuser']);

    // Create a domain for the user
    $this->domain = Domain::factory()->create([
        'user_id' => $this->user->id,
        'name' => 'testdomain.com',
    ]);

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

    // Mock the config to return a different domain than our test domain
    config(['app.domain' => 'maindomain.com']);
});

test('home component with custom domain displays user profile with search', function () {
    // Create a proper request with the custom domain
    $request = \Illuminate\Http\Request::create('http://testdomain.com/', 'GET', [], [], [], [
        'HTTP_HOST' => 'testdomain.com',
        'SERVER_NAME' => 'testdomain.com',
    ]);

    $this->app->instance('request', $request);

    Livewire::test(Home::class)
        ->assertSee($this->product1->name)
        ->assertSee($this->product2->name)
        ->assertSee($this->link1->title)
        ->assertSee($this->link2->title);
});

test('home component product search works with custom domain', function () {
    // Create a proper request with the custom domain
    $request = \Illuminate\Http\Request::create('http://testdomain.com/', 'GET', [], [], [], [
        'HTTP_HOST' => 'testdomain.com',
        'SERVER_NAME' => 'testdomain.com',
    ]);

    $this->app->instance('request', $request);

    Livewire::test(Home::class)
        ->set('productSearch', 'Laravel')
        ->assertSee($this->product1->name)
        ->assertDontSee($this->product2->name);
});

test('home component link search works with custom domain', function () {
    // Create a proper request with the custom domain
    $request = \Illuminate\Http\Request::create('http://testdomain.com/', 'GET', [], [], [], [
        'HTTP_HOST' => 'testdomain.com',
        'SERVER_NAME' => 'testdomain.com',
    ]);

    $this->app->instance('request', $request);

    Livewire::test(Home::class)
        ->set('linkSearch', 'Laravel')
        ->assertSee($this->link1->title)
        ->assertDontSee($this->link2->title);
});
