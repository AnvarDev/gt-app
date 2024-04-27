<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Url;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Url\DeleteUrlController
 */
class DeleteUrlControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Delete url request is blocks when the user is unauthorized
     */
    public function testDeleteUrlUnauthorized(): void
    {
        $this->post(route('url.delete', ['id' => fake()->randomDigitNotNull()]))
            ->assertStatus(302);
    }

    /**
     * Attempt to delete someone else's url record
     */
    public function testAttemptToDeleteWebRequest(): void
    {
        $user = User::factory()->create();
        $url = Url::factory()->create();

        $this->actingAs($user)
            ->post(route('url.delete', ['id' => $url->getKey()]))
            ->assertNotFound();

        $this->assertDatabaseHas(Url::class, [
            'id' => $url->getKey(),
        ]);
    }

    /**
     * Deleting url result is succeed and missed in the database
     */
    public function testDeleteUrlIsSucceed(): void
    {
        $user = User::factory()->has(
            Url::factory()
        )->create();
        $url = $user->urls()->first();

        $this->actingAs($user)
            ->post(route('url.delete', ['id' => $url->getKey()]))
            ->assertStatus(302);

        $this->assertDatabaseMissing(Url::class, [
            'id' => $url->getKey(),
        ]);
    }

    /**
     * Check API data of deleting someone else's url record
     */
    public function testAttemptToDeleteApiData(): void
    {
        $user = User::factory()->create();
        $url = Url::factory()->create();

        $this->actingAs($user)
            ->deleteJson(route('api.url.delete', ['id' => $url->getKey()]))
            ->assertNotFound();

        $this->assertDatabaseHas(Url::class, [
            'id' => $url->getKey(),
        ]);
    }

    /**
     * Check API data in the deleting url result
     */
    public function testDeleteUrlCheckApiData(): void
    {
        $user = User::factory()->has(
            Url::factory()
        )->create();
        $url = $user->urls()->first();

        $this->actingAs($user)
            ->deleteJson(route('api.url.delete', ['id' => $url->getKey()]))
            ->assertNoContent();

        $this->assertDatabaseMissing(Url::class, [
            'id' => $url->getKey(),
        ]);
    }
}
