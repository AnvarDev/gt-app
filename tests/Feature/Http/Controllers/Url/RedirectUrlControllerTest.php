<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Url;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Url\RedirectUrlController
 */
class RedirectUrlControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Redirecting to the target url result is succeed
     */
    public function testRedirectUrlIsSucceed(): void
    {
        $url = Url::factory()->create();

        $this->get(route('url.redirect', [$url->hash_id]))
            ->assertStatus(302)
            ->assertRedirect($url->url);
    }

    /**
     * Not found at the given hash_id.
     */
    public function testRedirectUrlNotFound(): void
    {
        $this->get(route('url.redirect', [fake()->sha1()]))
            ->assertNotFound();
    }
}
