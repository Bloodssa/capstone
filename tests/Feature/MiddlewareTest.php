<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Mockery\MockInterface;
uses(RefreshDatabase::class);

it('redirect customer access away to admin and staff', function () {
    $customer = User::factory()->create(['role' => 'customer']);

    // $response->assertStatus(200);
    $this->actingAs($customer)->get('/staff/dashboard')->assertRedirect('/dashboard');
    $this->actingAs($customer)->get('/admin/dashboard')->assertRedirect('/dashboard');
});

it('redirect staff and admin to there dashboard', function () {
    $staff = User::factory()->create(['role' => 'staff']);
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($staff)->get('/dashboard')->assertRedirect('/staff/dashboard');
    $this->actingAs($admin)->get('/dashboard')->assertRedirect('/admin/dashboard');
});
