<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\ChartCategory;
use App\Models\ChartProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ChartCategoryController
 */
class ChartCategoryControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $chartCategories = ChartCategory::factory()->count(3)->create();

        $response = $this->get(route('chart-category.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ChartCategoryController::class,
            'store',
            \App\Http\Requests\ChartCategoryStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $chart_category = $this->faker->word;
        $chart_provider = ChartProvider::factory()->create();

        $response = $this->post(route('chart-category.store'), [
            'chart_category' => $chart_category,
            'chart_provider_id' => $chart_provider->id,
        ]);

        $chartCategories = ChartCategory::query()
            ->where('chart_category', $chart_category)
            ->where('chart_provider_id', $chart_provider->id)
            ->get();
        $this->assertCount(1, $chartCategories);
        $chartCategory = $chartCategories->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $chartCategory = ChartCategory::factory()->create();

        $response = $this->get(route('chart-category.show', $chartCategory));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ChartCategoryController::class,
            'update',
            \App\Http\Requests\ChartCategoryUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $chartCategory = ChartCategory::factory()->create();
        $chart_category = $this->faker->word;
        $chart_provider = ChartProvider::factory()->create();

        $response = $this->put(route('chart-category.update', $chartCategory), [
            'chart_category' => $chart_category,
            'chart_provider_id' => $chart_provider->id,
        ]);

        $chartCategory->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($chart_category, $chartCategory->chart_category);
        $this->assertEquals($chart_provider->id, $chartCategory->chart_provider_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $chartCategory = ChartCategory::factory()->create();

        $response = $this->delete(route('chart-category.destroy', $chartCategory));

        $response->assertNoContent();

        $this->assertSoftDeleted($chartCategory);
    }
}
