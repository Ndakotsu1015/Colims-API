<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuAuthorization;
use App\Models\Privilege;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\MenuAuthorizationController
 */
class MenuAuthorizationControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @var \Illuminate\Foundation\Auth\User
     */
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        // $this->seed();
        $this->withHeader('X-Requested-With', 'XMLHttpRequest');
        $this->withHeader('Accept', 'application/json');

        
        User::withoutEvents(function () {
            $this->user = User::factory()->create([
                'name' => 'abdul',
                'email' => $this->faker->unique()->safeEmail,
                'password' => bcrypt("123456"),
            ]);
        });

        Sanctum::actingAs($this->user);
    }

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $menuAuthorizations = MenuAuthorization::factory()->count(3)->create();

        $response = $this->get(route('menu-authorizations.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MenuAuthorizationController::class,
            'store',
            \App\Http\Requests\MenuAuthorizationStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $menu = Menu::factory()->create();
        $privilege = Privilege::factory()->create();

        $response = $this->post(route('menu-authorizations.store'), [
            'menu_id' => $menu->id,
            'privilege_id' => $privilege->id,
        ]);

        $menuAuthorizations = MenuAuthorization::query()
            ->where('menu_id', $menu->id)
            ->where('privilege_id', $privilege->id)
            ->get();
        $this->assertCount(1, $menuAuthorizations);
        $menuAuthorization = $menuAuthorizations->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $menuAuthorization = MenuAuthorization::factory()->create();

        $response = $this->get(route('menu-authorizations.show', $menuAuthorization));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MenuAuthorizationController::class,
            'update',
            \App\Http\Requests\MenuAuthorizationUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $menuAuthorization = MenuAuthorization::factory()->create();
        $menu = Menu::factory()->create();
        $privilege = Privilege::factory()->create();

        $response = $this->put(route('menu-authorizations.update', $menuAuthorization), [
            'menu_id' => $menu->id,
            'privilege_id' => $privilege->id,
        ]);

        $menuAuthorization->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($menu->id, $menuAuthorization->menu_id);
        $this->assertEquals($privilege->id, $menuAuthorization->privilege_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $menuAuthorization = MenuAuthorization::factory()->create();

        $response = $this->delete(route('menu-authorizations.destroy', $menuAuthorization));

        $response->assertNoContent();

        $this->assertSoftDeleted($menuAuthorization);
    }
}
