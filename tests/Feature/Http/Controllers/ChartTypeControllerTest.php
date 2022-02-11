<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\ChartCategory;
use App\Models\ChartType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ChartTypeController
 */
class ChartTypeControllerTest extends TestCase
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
        $chartTypes = ChartType::inRandomOrder()->limit(3)->get();

        $response = $this->get(route('chart-type.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ChartTypeController::class,
            'store',
            \App\Http\Requests\ChartTypeStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $chart_type = $this->faker->word;
        $chart_category = ChartCategory::inRandomOrder()->first();

        $response = $this->post(route('chart-type.store'), [
            'chart_type' => $chart_type,
            'chart_category_id' => $chart_category->id,
        ]);

        $chartTypes = ChartType::query()
            ->where('chart_type', $chart_type)
            ->where('chart_category_id', $chart_category->id)
            ->get();
        $this->assertCount(1, $chartTypes);
        $chartType = $chartTypes->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $chartType = ChartType::inRandomOrder()->first();

        $response = $this->get(route('chart-type.show', $chartType));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ChartTypeController::class,
            'update',
            \App\Http\Requests\ChartTypeUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $chartType = ChartType::inRandomOrder()->first();
        $chart_type = $this->faker->word;
        $chart_category = ChartCategory::inRandomOrder()->first();

        $response = $this->put(route('chart-type.update', $chartType), [
            'chart_type' => $chart_type,
            'chart_category_id' => $chart_category->id,
        ]);

        $chartType->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($chart_type, $chartType->chart_type);
        $this->assertEquals($chart_category->id, $chartType->chart_category_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $chartType = ChartType::inRandomOrder()->first();

        $response = $this->delete(route('chart-type.destroy', $chartType));

        $response->assertNoContent();

        $this->assertSoftDeleted($chartType);
    }
}
