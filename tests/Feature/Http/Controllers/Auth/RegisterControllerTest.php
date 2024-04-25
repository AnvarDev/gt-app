<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Auth\RegisterController
 */
class RegisterControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Missed required details in the register form
     */
    public function testRegisterValidation(): void
    {
        $this->post(route('register'))
            ->assertSessionHasErrors(['name', 'email', 'password'])
            ->assertStatus(302);

        $this->postJson(route('api.register'))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    /**
     * Register form validation with invalid passwords
     */
    public function testRegisterPasswordsMismatch(): void
    {
        $this->post(route('register'), [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'password' => fake()->password(8),
            'password_confirmation' => fake()->password(8),
        ])
            ->assertSessionHasErrors(['password'])
            ->assertStatus(302);

        $this->postJson(route('api.register'), [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'password' => fake()->password(8),
            'password_confirmation' => fake()->password(8),
        ])
            ->assertJsonValidationErrors(['password'])
            ->assertStatus(422);
    }

    /**
     * Register form request with successful registration (web)
     */
    public function testRegisterWebSuccess(): void
    {
        $email = fake()->email();
        $password = fake()->password(8);

        $this->post(route('register'), [
            'name' => fake()->name(),
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ])
            ->assertSessionHasNoErrors()
            ->assertStatus(302)
            ->assertRedirect(route('home'));

        $this->assertDatabaseHas(User::class, [
            'email' => $email,
        ]);
    }

    /**
     * Register form request with successful registration (API)
     */
    public function testRegisterApiSuccess(): void
    {
        $email = fake()->email();
        $password = fake()->password(8);

        $this->postJson(route('api.register'), [
            'name' => fake()->name(),
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ])
            ->assertCreated()
            ->assertJsonStructure([
                'data' => [
                    'name', 'email',
                ],
                'token',
            ]);

        $this->assertDatabaseHas(User::class, [
            'email' => $email,
        ]);
    }
}
