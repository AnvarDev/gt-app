<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Url;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Url\CreateUrlController
 */
class CreateUrlControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Create url request is blocks when the user is unauthorized
     */
    public function testCreateUrlUnauthorized(): void
    {
        $this->post(route('url.create'))
            ->assertStatus(302);
    }

    /**
     * Validations for the creating url request
     */
    public function testCreateUrlValidation(): void
    {
        $this->actingAs(User::factory()->create())
            ->post(route('url.create'))
            ->assertStatus(302);
    }

    /**
     * Creating url result is succeed and exists in the database
     */
    public function testCreateUrlIsSucceed(): void
    {
        $target_url = fake()->url();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('url.create'), [
                'url' => $target_url,
            ])->assertStatus(302);

        $this->assertDatabaseHas(Url::class, [
            'user_id' => $user->getKey(),
            'url' => $target_url,
        ]);
    }

    /**
     * Validations of API data in the creating url result
     */
    public function testCreateUrlValidationApiData(): void
    {
        $this->actingAs(User::factory()->create())
            ->postJson(route('api.url.create'))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['url']);
    }

    /**
     * Check API data in the creating url result
     */
    public function testCreateUrlCheckApiData(): void
    {
        $target_url = fake()->url();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(route('api.url.create'), [
                'url' => $target_url,
            ])->assertCreated()
            ->assertJsonStructure([
                'data' => [
                    'id', 'hash_id', 'url', 'short_url', 'created_at', 'updated_at',
                ],
            ]);

        $this->assertDatabaseHas(Url::class, [
            'user_id' => $user->getKey(),
            'url' => $target_url,
        ]);
    }
}
