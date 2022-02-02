<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\CaseStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CaseStatusController
 */
class CaseStatusControllerTest extends TestCase
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
        $caseStatuses = CaseStatus::factory()->count(3)->create();

        $response = $this->get(route('case-status.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CaseStatusController::class,
            'store',
            \App\Http\Requests\CaseStatusStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $name = $this->faker->name;

        $response = $this->post(route('case-status.store'), [
            'name' => $name,
        ]);

        $caseStatuses = CaseStatus::query()
            ->where('name', $name)
            ->get();
        $this->assertCount(1, $caseStatuses);
        $caseStatus = $caseStatuses->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $caseStatus = CaseStatus::factory()->create();

        $response = $this->get(route('case-status.show', $caseStatus));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CaseStatusController::class,
            'update',
            \App\Http\Requests\CaseStatusUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $caseStatus = CaseStatus::factory()->create();
        $name = $this->faker->name;

        $response = $this->put(route('case-status.update', $caseStatus), [
            'name' => $name,
        ]);

        $caseStatus->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $caseStatus->name);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $caseStatus = CaseStatus::factory()->create();

        $response = $this->delete(route('case-status.destroy', $caseStatus));

        $response->assertNoContent();

        $this->assertSoftDeleted($caseStatus);
    }
}
