<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Menu;
use App\Models\Module;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use \JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\MenuController
 */
class MenuControllerTest extends TestCase
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
        $menus = Menu::factory()->count(3)->create();

        $response = $this->get(route('menu.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MenuController::class,
            'store',
            \App\Http\Requests\MenuStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $link = $this->faker->word;
        $is_active = $this->faker->boolean;
        $parent = Menu::factory()->create();
        $module = Module::factory()->create();

        $response = $this->post(route('menu.store'), [
            'link' => $link,
            'is_active' => $is_active,
            'parent_id' => $parent->id,
            'module_id' => $module->id,
        ]);

        $menus = Menu::query()
            ->where('link', $link)
            ->where('is_active', $is_active)
            ->where('parent_id', $parent->id)
            ->where('module_id', $module->id)
            ->get();
        $this->assertCount(1, $menus);
        $menu = $menus->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $menu = Menu::factory()->create();

        $response = $this->get(route('menu.show', $menu));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MenuController::class,
            'update',
            \App\Http\Requests\MenuUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $menu = Menu::factory()->create();
        $link = $this->faker->word;
        $is_active = $this->faker->boolean;
        $parent = Menu::factory()->create();
        $module = Module::factory()->create();

        $response = $this->put(route('menu.update', $menu), [
            'link' => $link,
            'is_active' => $is_active,
            'parent_id' => $parent->id,
            'module_id' => $module->id,
        ]);

        $menu->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($link, $menu->link);
        $this->assertEquals($is_active, $menu->is_active);
        $this->assertEquals($parent->id, $menu->parent_id);
        $this->assertEquals($module->id, $menu->module_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $menu = Menu::factory()->create();

        $response = $this->delete(route('menu.destroy', $menu));

        $response->assertNoContent();

        $this->assertSoftDeleted($menu);
    }
}
