<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Chart;
use App\Models\ChartCategory;
use App\Models\ChartType;
use App\Models\DashboardSetting;
use App\Models\Module;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DashboardSettingController
 */
class DashboardSettingControllerTest extends TestCase
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
        $dashboardSettings = DashboardSetting::factory()->count(3)->create();

        $response = $this->get(route('dashboard-setting.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DashboardSettingController::class,
            'store',
            \App\Http\Requests\DashboardSettingStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $chart_title = $this->faker->word;
        $is_active = $this->faker->boolean;
        $orderby = $this->faker->randomNumber();
        $is_group = $this->faker->boolean;
        $sub_module_id = 12;
        $chart = Chart::factory()->create();
        $module = Module::factory()->create();
        $chart_type = ChartType::inRandomOrder()->first();
        $chart_category = ChartCategory::inRandomOrder()->first();

        $response = $this->post(route('dashboard-setting.store'), [
            'chart_title' => $chart_title,
            'is_active' => $is_active,
            'orderby' => $orderby,
            'is_group' => $is_group,
            'sub_module_id' => $sub_module_id,
            'chart_id' => $chart->id,
            'module_id' => $module->id,
            'chart_type_id' => $chart_type->id,
            'chart_category_id' => $chart_category->id,
        ]);

        $dashboardSettings = DashboardSetting::query()
            ->where('chart_title', $chart_title)
            ->where('is_active', $is_active)
            ->where('orderby', $orderby)
            ->where('is_group', $is_group)
            ->where('sub_module_id', $sub_module_id)
            ->where('chart_id', $chart->id)
            ->where('module_id', $module->id)
            ->where('chart_type_id', $chart_type->id)
            ->where('chart_category_id', $chart_category->id)
            ->get();
        $this->assertCount(1, $dashboardSettings);
        $dashboardSetting = $dashboardSettings->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $dashboardSetting = DashboardSetting::factory()->create();

        $response = $this->get(route('dashboard-setting.show', $dashboardSetting));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DashboardSettingController::class,
            'update',
            \App\Http\Requests\DashboardSettingUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $dashboardSetting = DashboardSetting::factory()->create();
        $chart_title = $this->faker->word;
        $is_active = $this->faker->boolean;
        $orderby = $this->faker->randomNumber();
        $is_group = $this->faker->boolean;
        $sub_module_id = $this->faker->randomNumber();
        $chart = Chart::factory()->create();
        $module = Module::factory()->create();
        $chart_type = ChartType::inRandomOrder()->first();
        $chart_category = ChartCategory::inRandomOrder()->first();

        $response = $this->put(route('dashboard-setting.update', $dashboardSetting), [
            'chart_title' => $chart_title,
            'is_active' => $is_active,
            'orderby' => $orderby,
            'is_group' => $is_group,
            'sub_module_id' => $sub_module_id,
            'chart_id' => $chart->id,
            'module_id' => $module->id,
            'chart_type_id' => $chart_type->id,
            'chart_category_id' => $chart_category->id,
        ]);

        $dashboardSetting->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($chart_title, $dashboardSetting->chart_title);
        $this->assertEquals($is_active, $dashboardSetting->is_active);
        $this->assertEquals($orderby, $dashboardSetting->orderby);
        $this->assertEquals($is_group, $dashboardSetting->is_group);
        $this->assertEquals($sub_module_id, $dashboardSetting->sub_module_id);
        $this->assertEquals($chart->id, $dashboardSetting->chart_id);
        $this->assertEquals($module->id, $dashboardSetting->module_id);
        $this->assertEquals($chart_type->id, $dashboardSetting->chart_type_id);
        $this->assertEquals($chart_category->id, $dashboardSetting->chart_category_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $dashboardSetting = DashboardSetting::factory()->create();

        $response = $this->delete(route('dashboard-setting.destroy', $dashboardSetting));

        $response->assertNoContent();

        $this->assertSoftDeleted($dashboardSetting);
    }
}
