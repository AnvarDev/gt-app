<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Url;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\IndexController
 */
class IndexControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Check the http code of the index page when the user is unauthorized
     */
    public function testHomePageWhenUserUnauthorized(): void
    {
        $this->get(route('home'))
            ->assertStatus(302);
    }

    /**
     * Check the http code of the index page when the user is authorized
     */
    public function testHomePageWhenUserAuthorized(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('home'))
            ->assertOk();
    }

    /**
     * Check the urls list pagination of the index page
     */
    public function testHomePageUrlsListViewPagination(): void
    {
        $user = User::factory()->has(
            Url::factory()->count(25)
        )->create();

        $this->actingAs($user)
            ->get(route('home', ['page' => 1]))
            ->assertOk()
            ->assertDontSee('Go to page 1')
            ->assertSee('Go to page 2');

        $this->actingAs($user)
            ->get(route('home', ['page' => 2]))
            ->assertOk()
            ->assertSee('Go to page 1')
            ->assertDontSee('Go to page 2');
    }

    /**
     * Check API data in the urls list on the index page
     */
    public function testHomePageUrlsListCheckApiData(): void
    {
        $this->actingAs(User::factory()->has(
            Url::factory()->count(25)
        )->create())
            ->getJson(route('api.url.home'))
            ->assertOk()
            ->assertJsonCount(20, 'data')
            ->assertJsonStructure([
                'data' => [
                    ['id', 'hash_id', 'url', 'short_url', 'created_at', 'updated_at'],
                ],
                'links' => [
                    'first', 'last', 'prev', 'next',
                ],
                'meta' => [
                    'current_page', 'last_page', 'links', 'per_page', 'total',
                ],
            ]);
    }

    /**
     * Check the elements of the form page view for creating a new url
     */
    public function testFormForCreatingANewUrl(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('url.form'))
            ->assertOk()
            ->assertSee('Target URL')
            ->assertSee('Create');
    }

    /**
     * Check the elements of the form page view for updating the url
     */
    public function testFormForUpdatingTheUrl(): void
    {
        $user = User::factory()->has(
            Url::factory()
        )->create();

        $this->actingAs($user)
            ->get(route('url.form', ['id' => $user->urls()->first()->getKey()]))
            ->assertOk()
            ->assertSee('Target URL')
            ->assertSee('Update');
    }

    /**
     * Check the elements of the form page view for updating the url of another user
     */
    public function testFormForUpdatingNotFound(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('url.form', ['id' => Url::factory()->create()->getKey()]))
            ->assertNotFound();
    }
}
