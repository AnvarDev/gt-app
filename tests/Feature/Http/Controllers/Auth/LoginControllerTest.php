<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Auth\LoginController
 */
class LoginControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Missed required details in the login form
     */
    public function testLoginValidation(): void
    {
        $this->post(route('login'))
            ->assertSessionHasErrors(['email', 'password'])
            ->assertStatus(302);

        $this->postJson(route('api.login'))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email', 'password']);
    }

    /**
     * User doesn't exist
     */
    public function testLoginNotFound(): void
    {
        $this->post(route('login'), [
            'email' => fake()->email(),
            'password' => fake()->password(8),
        ])
            ->assertSessionHasErrors(['email'])
            ->assertStatus(302);

        $this->postJson(route('api.login'), [
            'email' => fake()->email(),
            'password' => fake()->password(8),
        ])
            ->assertJsonValidationErrors(['email'])
            ->assertStatus(422);
    }

    /**
     * Login form validation with an invalid password
     */
    public function testLoginInvalidCredentials(): void
    {
        $user = User::factory()->create();

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => fake()->password(8),
        ])
            ->assertSessionHasErrors(['email'])
            ->assertStatus(302);

        $this->postJson(route('api.login'), [
            'email' => $user->email,
            'password' => fake()->password(8),
        ])
            ->assertJsonValidationErrors(['email'])
            ->assertStatus(422);
    }

    /**
     * Login form request with the expired CSRF token
     */
    public function testLoginCsrfTokenMismatch(): void
    {
        $password = fake()->password(8);
        $user = User::factory()->create([
            'password' => $password
        ]);

        $this->partialMock(ValidateCsrfToken::class, function ($mock) {
            $mock->shouldAllowMockingProtectedMethods();
            $mock->shouldReceive('getExcludedPaths')->once()->andReturn([]);
            $mock->shouldReceive('runningUnitTests')->once()->andReturnFalse();
        });

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => $password,
        ])->assertStatus(419);
    }

    /**
     * Login form request with successful authorisation (web)
     */
    public function testLoginWebAuthorisation(): void
    {
        $password = fake()->password(8);
        $user = User::factory()->create([
            'password' => $password
        ]);

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => $password,
        ])
            ->assertSessionHasNoErrors()
            ->assertStatus(302)
            ->assertRedirect(route('home'));
    }

    /**
     * Login form request with successful authorisation (API)
     */
    public function testLoginApiAuthorisation(): void
    {
        $password = fake()->password(8);
        $user = User::factory()->create([
            'password' => $password
        ]);

        $this->postJson(route('api.login'), [
            'email' => $user->email,
            'password' => $password,
        ])
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'name', 'email',
                ],
                'token',
            ]);
    }

    /**
     * Successful logout request
     */
    public function testLogoutSuccess(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('logout'))
            ->assertStatus(302)
            ->assertRedirect(route('home'));

        $this->actingAs($user)
            ->postJson(route('api.logout'))
            ->assertNoContent();
    }
}
