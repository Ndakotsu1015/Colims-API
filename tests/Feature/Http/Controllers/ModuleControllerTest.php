<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Module;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ModuleController
 */
class ModuleControllerTest extends TestCase
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
        $modules = Module::factory()->count(3)->create();

        $response = $this->get(route('module.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ModuleController::class,
            'store',
            \App\Http\Requests\ModuleStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $name = $this->faker->name;
        $order_by = $this->faker->randomNumber();
        $active_id = $this->faker->randomNumber();
        $url = $this->faker->url;
        $created_by = $this->faker->randomNumber();
        $modified_by = $this->faker->randomNumber();
        $icon = $this->faker->word;
        $bg_class = $this->faker->word;

        $response = $this->post(route('module.store'), [
            'name' => $name,
            'order_by' => $order_by,
            'active_id' => $active_id,
            'url' => $url,
            'created_by' => $created_by,
            'modified_by' => $modified_by,
            'icon' => $icon,
            'bg_class' => $bg_class,
        ]);

        $modules = Module::query()
            ->where('name', $name)
            ->where('order_by', $order_by)
            ->where('active_id', $active_id)
            ->where('url', $url)
            ->where('created_by', $created_by)
            ->where('modified_by', $modified_by)
            ->where('icon', $icon)
            ->where('bg_class', $bg_class)
            ->get();
        $this->assertCount(1, $modules);
        $module = $modules->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $module = Module::factory()->create();

        $response = $this->get(route('module.show', $module));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ModuleController::class,
            'update',
            \App\Http\Requests\ModuleUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $module = Module::factory()->create();
        $name = $this->faker->name;
        $order_by = $this->faker->randomNumber();
        $active_id = $this->faker->randomNumber();
        $url = $this->faker->url;
        $created_by = $this->faker->randomNumber();
        $modified_by = $this->faker->randomNumber();
        $icon = $this->faker->word;
        $bg_class = $this->faker->word;

        $response = $this->put(route('module.update', $module), [
            'name' => $name,
            'order_by' => $order_by,
            'active_id' => $active_id,
            'url' => $url,
            'created_by' => $created_by,
            'modified_by' => $modified_by,
            'icon' => $icon,
            'bg_class' => $bg_class,
        ]);

        $module->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $module->name);
        $this->assertEquals($order_by, $module->order_by);
        $this->assertEquals($active_id, $module->active_id);
        $this->assertEquals($url, $module->url);
        $this->assertEquals($created_by, $module->created_by);
        $this->assertEquals($modified_by, $module->modified_by);
        $this->assertEquals($icon, $module->icon);
        $this->assertEquals($bg_class, $module->bg_class);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $module = Module::factory()->create();

        $response = $this->delete(route('module.destroy', $module));

        $response->assertNoContent();

        $this->assertSoftDeleted($module);
    }
}
