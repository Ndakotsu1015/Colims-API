<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\ChartProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ChartProviderController
 */
class ChartProviderControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $chartProviders = ChartProvider::factory()->count(3)->create();

        $response = $this->get(route('chart-provider.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ChartProviderController::class,
            'store',
            \App\Http\Requests\ChartProviderStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $chart_provider = $this->faker->word;

        $response = $this->post(route('chart-provider.store'), [
            'chart_provider' => $chart_provider,
        ]);

        $chartProviders = ChartProvider::query()
            ->where('chart_provider', $chart_provider)
            ->get();
        $this->assertCount(1, $chartProviders);
        $chartProvider = $chartProviders->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $chartProvider = ChartProvider::factory()->create();

        $response = $this->get(route('chart-provider.show', $chartProvider));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ChartProviderController::class,
            'update',
            \App\Http\Requests\ChartProviderUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $chartProvider = ChartProvider::factory()->create();
        $chart_provider = $this->faker->word;

        $response = $this->put(route('chart-provider.update', $chartProvider), [
            'chart_provider' => $chart_provider,
        ]);

        $chartProvider->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($chart_provider, $chartProvider->chart_provider);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $chartProvider = ChartProvider::factory()->create();

        $response = $this->delete(route('chart-provider.destroy', $chartProvider));

        $response->assertNoContent();

        $this->assertSoftDeleted($chartProvider);
    }
}
