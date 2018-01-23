<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LaravelEnvTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRoot()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_login()
    {
        $password = "123456";
        $user = factory(User::class)->create(['password' =>bcrypt($password)]);
        $response = $this->get('/login');
        $response->assertStatus(200);
    }
}
