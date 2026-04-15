<?php

use App\Models\User;
// use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('authenticated user can create a client', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->postJson('/api/clients', [
            'name' => 'Wandumi Company'
        ]);

    $response->assertStatus(201)
             ->assertJsonPath('name', 'Wandumi Company');

    $this->assertDatabaseHas('clients', [
        'name' => 'Wandumi Company'
    ]);
});

test('guest cannot create a client', function () {
    $this->postJson('/api/clients', ['name' => 'Should Fail'])
         ->assertStatus(401);
});
