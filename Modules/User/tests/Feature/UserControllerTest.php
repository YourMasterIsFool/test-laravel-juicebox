<?php

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;

uses(Tests\TestCase::class, DatabaseTransactions::class);

it('should be email telah digunakan',  function () {

    User::factory()->create([
        'name' => 'test',
        "email" => "testmok@gmail.com",
        "password" => Hash::make(('test12345678'))
    ]);
    $mockData = [
        'name' => 'test',
        "email" => "testmok@gmail.com",
        "password" => "test23083201"
    ];
    $response =  $this->postJson('/api/register', $mockData);
    $response->assertStatus(400)
        ->assertJsonValidationErrors(
            [
                "email" => [
                    'Email sudah digunakan'
                ]
            ],
        );
});
it('register new user',  function () {
    $mockData = [
        'name' => 'test',
        "email" => "test4@gmail.com",
        "password" => "test23083201"
    ];

    $response =  $this->postJson('/api/register', $mockData);

    $response->assertStatus(201)
        ->assertJson([
            'message' => 'Successfully register user',
            "data" => [
                "name" => "test",
                "email" => "test4@gmail.com"
            ]
        ]);

    $this->assertDatabaseHas('users', [
        'name' => 'test',
        'email' => 'test4@gmail.com'
    ]);
});


it('should be email not found when login', function () {
    $mockData = [
        'name' => 'test',
        "email" => "testmok@gmail.com",
        "password" => "test23083201"
    ];
    $response = $this->postJson('/api/login', $mockData);
    $response->assertStatus(400)
        ->assertJsonValidationErrors([
            'email' => ["Email tidak terdaftar"]
        ]);
});

it('requires a name, email, and password', function () {
    $response = $this->postJson('/api/register', []);

    $response->assertStatus(400)
        ->assertJsonValidationErrors(['name', 'email', 'password']);
});
