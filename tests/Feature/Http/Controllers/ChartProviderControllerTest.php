<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\ChartProvider;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ChartProviderController
 */
class ChartProviderControllerTest extends TestCase
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
        $chartProviders = ChartProvider::inRandomOrder()->take(3)->get();

        $response = $this->get(route('chart-providers.index'));

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

        $response = $this->post(route('chart-providers.store'), [
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
        $chartProvider = ChartProvider::inRandomOrder()->first();

        $response = $this->get(route('chart-providers.show', $chartProvider));

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
        $chartProvider = ChartProvider::inRandomOrder()->first();
        $chart_provider = $this->faker->word;

        $response = $this->put(route('chart-providers.update', $chartProvider), [
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
        $chartProvider = ChartProvider::inRandomOrder()->first();

        $response = $this->delete(route('chart-providers.destroy', $chartProvider));

        $response->assertNoContent();

        $this->assertSoftDeleted($chartProvider);
    }
}
