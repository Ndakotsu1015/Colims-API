<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\CourtCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CourtCaseController
 */
class CourtCaseControllerTest extends TestCase
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
        $courtCases = CourtCase::factory()->count(3)->create();

        $response = $this->get(route('court-case.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CourtCaseController::class,
            'store',
            \App\Http\Requests\CourtCaseStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $title = $this->faker->sentence(4);
        $case_no = $this->faker->word;
        $status = $this->faker->word;
        $handler = User::factory()->create();
        $posted_by = User::factory()->create();

        $response = $this->post(route('court-case.store'), [
            'title' => $title,
            'case_no' => $case_no,
            'status' => $status,
            'handler_id' => $handler->id,
            'posted_by' => $posted_by->id,
        ]);

        $courtCases = CourtCase::query()
            // ->where('title', $title)
            ->where('case_no', $case_no)
            // ->where('status', $status)
            // ->where('handler_id', $handler->id)
            // ->where('posted_by', $posted_by->id)
            ->get();
        $this->assertCount(1, $courtCases);
        $courtCase = $courtCases->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $courtCase = CourtCase::factory()->create();

        $response = $this->get(route('court-case.show', $courtCase));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CourtCaseController::class,
            'update',
            \App\Http\Requests\CourtCaseUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $courtCase = CourtCase::factory()->create();
        $title = $this->faker->sentence(4);
        $case_no = $this->faker->word;
        $status = $this->faker->word;
        $handler = User::factory()->create();
        $posted_by = User::factory()->create();

        $response = $this->put(route('court-case.update', $courtCase), [
            'title' => $title,
            'case_no' => $case_no,
            'status' => $status,
            'handler_id' => $handler->id,
            'posted_by' => $posted_by->id,
        ]);

        $courtCase->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($title, $courtCase->title);
        $this->assertEquals($case_no, $courtCase->case_no);
        $this->assertEquals($status, $courtCase->status);
        $this->assertEquals($handler->id, $courtCase->handler_id);
        $this->assertEquals($posted_by->id, $courtCase->posted_by);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $courtCase = CourtCase::factory()->create();

        $response = $this->delete(route('court-case.destroy', $courtCase));

        $response->assertNoContent();

        $this->assertSoftDeleted($courtCase);
    }
}
