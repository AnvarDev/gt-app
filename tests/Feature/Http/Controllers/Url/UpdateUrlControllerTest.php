<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Url;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Url\UpdateUrlController
 */
class UpdateUrlControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Update url request is blocks when the user is unauthorized
     */
    public function testUpdateUrlUnauthorized(): void
    {
        $this->post(route('url.update', ['id' => fake()->randomDigitNotNull()]))
            ->assertStatus(302);
    }

    /**
     * Validations for the updating url request
     */
    public function testUpdateUrlValidation(): void
    {
        $this->actingAs(User::factory()->create())
            ->post(route('url.update', ['id' => fake()->randomDigitNotNull()]))
            ->assertStatus(302);
    }

    /**
     * Updating url result is succeed and exists in the database
     */
    public function testUpdateUrlIsSucceed(): void
    {
        $target_url = fake()->url();
        $user = User::factory()->has(
            Url::factory()
        )->create();
        $url = $user->urls()->first();

        $this->actingAs($user)
            ->post(route('url.update', ['id' => $url->getKey()]), [
                'url' => $target_url,
            ])->assertStatus(302);

        $this->assertDatabaseHas(Url::class, [
            'id' => $url->getKey(),
            'user_id' => $user->getKey(),
            'url' => $target_url,
        ]);
    }

    /**
     * Validations of API data in the updating url result
     */
    public function testUpdateUrlValidationApiData(): void
    {
        $this->actingAs(User::factory()->create())
            ->patchJson(route('api.url.update', ['id' => fake()->randomDigitNotNull()]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['url']);
    }

    /**
     * Check API data in the updating url result
     */
    public function testUpdateUrlCheckApiData(): void
    {
        $target_url = fake()->url();
        $user = User::factory()->has(
            Url::factory()
        )->create();
        $url = $user->urls()->first();

        $this->actingAs($user)
            ->patchJson(route('api.url.update', ['id' => $url->getKey()]), [
                'url' => $target_url,
            ])->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'id', 'hash_id', 'url', 'short_url', 'created_at', 'updated_at',
                ],
            ]);

        $this->assertDatabaseHas(Url::class, [
            'id' => $url->getKey(),
            'user_id' => $user->getKey(),
            'url' => $target_url,
        ]);
    }
}
