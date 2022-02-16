<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Chart;
use App\Models\ChartCategory;
use App\Models\ChartType;
use App\Models\Module;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ChartController
 */
class ChartControllerTest extends TestCase
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
        $charts = Chart::factory()->count(3)->create();

        $response = $this->get(route('charts.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ChartController::class,
            'store',
            \App\Http\Requests\ChartStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $chart_title = $this->faker->word;
        $sql_query = $this->faker->word;
        $is_active = $this->faker->boolean;
        $module = Module::factory()->create();
        $filter_column = $this->faker->word;
        $chart_type = ChartType::inRandomOrder()->first();
        $chart_category = ChartCategory::inRandomOrder()->first();

        $response = $this->post(route('charts.store'), [
            'chart_title' => $chart_title,
            'sql_query' => $sql_query,
            'is_active' => $is_active,
            'module_id' => $module->id,
            'filter_column' => $filter_column,
            'chart_type_id' => $chart_type->id,
            'chart_category_id' => $chart_category->id,
        ]);

        $charts = Chart::query()
            ->where('chart_title', $chart_title)
            ->where('sql_query', $sql_query)
            ->where('is_active', $is_active)
            ->where('module_id', $module->id)
            ->where('filter_column', $filter_column)
            ->where('chart_type_id', $chart_type->id)
            ->where('chart_category_id', $chart_category->id)
            ->get();
        $this->assertCount(1, $charts);
        $chart = $charts->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $chart = Chart::factory()->create();

        $response = $this->get(route('charts.show', $chart));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ChartController::class,
            'update',
            \App\Http\Requests\ChartUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $chart = Chart::factory()->create();
        $chart_title = $this->faker->word;
        $sql_query = $this->faker->word;
        $is_active = $this->faker->boolean;
        $module = Module::factory()->create();
        $filter_column = $this->faker->word;
        $chart_type = ChartType::inRandomOrder()->first();
        $chart_category = ChartCategory::inRandomOrder()->first();

        $response = $this->put(route('charts.update', $chart), [
            'chart_title' => $chart_title,
            'sql_query' => $sql_query,
            'is_active' => $is_active,
            'module_id' => $module->id,
            'filter_column' => $filter_column,
            'chart_type_id' => $chart_type->id,
            'chart_category_id' => $chart_category->id,
        ]);

        $chart->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($chart_title, $chart->chart_title);
        $this->assertEquals($sql_query, $chart->sql_query);
        $this->assertEquals($is_active, $chart->is_active);
        $this->assertEquals($module->id, $chart->module_id);
        $this->assertEquals($filter_column, $chart->filter_column);
        $this->assertEquals($chart_type->id, $chart->chart_type_id);
        $this->assertEquals($chart_category->id, $chart->chart_category_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $chart = Chart::factory()->create();

        $response = $this->delete(route('charts.destroy', $chart));

        $response->assertNoContent();

        $this->assertSoftDeleted($chart);
    }
}
