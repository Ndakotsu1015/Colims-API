<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\CaseRequest;
use App\Models\CaseStatus;
use App\Models\CourtCase;
use App\Models\Solicitor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
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
        $this->seed();
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

        $response = $this->get(route('court-cases.index'));

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
        $is_case_closed = $this->faker->boolean;
        $court_pronouncement = $this->faker->word;
        $handler = User::inRandomOrder()->first();
        $posted_by = User::inRandomOrder()->first();
        $case_status = CaseStatus::inRandomOrder()->first();        
        $solicitor = Solicitor::inRandomOrder()->first();  
        $case_request = CaseRequest::inRandomOrder()->first();;  

        $response = $this->post(route('court-cases.store'), [
            'title' => $title,
            'case_no' => $case_no,            
            'is_case_closed' => $is_case_closed,
            'court_pronouncement' => $court_pronouncement,
            'handler_id' => $handler->id,
            'posted_by' => $posted_by->id,
            'case_status_id' => $case_status->id,            
            'solicitor_id' => $solicitor->id,
            'case_request_id' => $case_request->id,
        ]);

        $courtCases = CourtCase::query()
            ->where('title', $title)
            ->where('case_no', $case_no)            
            ->where('is_case_closed', $is_case_closed)
            ->where('court_pronouncement', $court_pronouncement)
            ->where('handler_id', $handler->id)
            ->where('posted_by', $posted_by->id)
            ->where('case_status_id', $case_status->id)            
            ->where('case_request_id', $case_request->id)
            ->where('solicitor_id', $solicitor->id)
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

        $response = $this->get(route('court-cases.show', $courtCase));

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
        $courtCase = CourtCase::inRandomOrder()->first();
        $title = $this->faker->sentence(4);
        $case_no = $this->faker->word;        
        $is_case_closed = $this->faker->boolean;
        $handler = User::inRandomOrder()->first();
        $solicitor = Solicitor::inRandomOrder()->first();

        $response = $this->put(route('court-cases.update', $courtCase), [
            'title' => $title,
            'case_no' => $case_no,        
            'is_case_closed' => $is_case_closed,           
            'handler_id' => $handler->id,           
            'solicitor_id' => $solicitor->id,
        ]);

        
        Log::debug($response->getContent());

        $courtCase->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($title, $courtCase->title);
        $this->assertEquals($case_no, $courtCase->case_no);        
        $this->assertEquals($is_case_closed, $courtCase->is_case_closed);
        $this->assertEquals($handler->id, $courtCase->handler_id);
        $this->assertEquals($solicitor->id, $solicitor->solicitor_id);     
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $courtCase = CourtCase::factory()->create();

        $response = $this->delete(route('court-cases.destroy', $courtCase));

        $response->assertNoContent();

        $this->assertSoftDeleted($courtCase);
    }
}
