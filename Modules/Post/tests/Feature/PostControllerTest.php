<?php

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Post\Models\Post;

uses(Tests\TestCase::class, DatabaseTransactions::class);

it("test protected route post", function () {
    $user = User::factory()->create();
    $token = $user->createToken('test-token')->plainTextToken;

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json'
    ])->getJson('/api/post/list');

    $response->assertStatus(200);
});


it("it should return 401 when unauthorized", function () {
    $response = $this->withHeaders([
        'Accept' => 'application/json'
    ])->getJson('/api/post/list');

    $response->assertStatus(401);
});


it("should require title and description", function () {
    $user = User::factory()->create();
    $token = $user->createToken('test-token')->plainTextToken;

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json'
    ])->postJson('/api/post/store', []);


    $response->assertStatus(400)
        ->assertJsonValidationErrors(['title', 'description']);
});

it("test success update", function () {
    $user = User::factory()->create();
    $token = $user->createToken('test-token')->plainTextToken;


    $post =  Post::create([
        'title' => 'test',
        'description' => 'test',
        'user_id' => $user->id,
    ]);


    $mockData =  [
        'title' => 'update',
        'description' => 'update desc'
    ];


    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json'
    ])->patchJson('/api/post/update/' . $post->id, $mockData);


    $response->assertStatus(201)
        ->assertJson([
            'data' => [
                'title' => 'update',
                'description' => 'update desc'
            ]
        ]);
});
