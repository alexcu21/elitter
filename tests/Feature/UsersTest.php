<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCanSeeUserPage()
    {
        $user = factory(User::class)->create();
        $response = $this->get($user->username);
        $response->assertSee($user->username);
    }
}
