<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
    // use RefreshDatabase;

    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $user = factory(User::class)->create([
            'email' => 'jing1.min@163.com'
        ]);
        print_r($user);
        $this->browse(function (Browser $browser)use($user) {

            $browser->visit('/login')
                ->type('email',$user->email)
                ->type('password', '123456')
                ->press('Login')
                ->assertPathIs('/home');
        });
    }
}
