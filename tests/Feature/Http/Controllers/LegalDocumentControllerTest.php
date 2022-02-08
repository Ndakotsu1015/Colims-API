<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\CourtCase;
use App\Models\LegalDocument;
use App\Models\LegalDocumentType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\LegalDocumentController
 */
class LegalDocumentControllerTest extends TestCase
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
        $legalDocuments = LegalDocument::factory()->count(3)->create();

        $response = $this->get(route('legal-document.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\LegalDocumentController::class,
            'store',
            \App\Http\Requests\LegalDocumentStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $title = $this->faker->sentence(4);
        $filename = $this->faker->word;
        $user = User::factory()->create();
        $court_case = CourtCase::factory()->create();
        $document_type = LegalDocumentType::factory()->create();

        $response = $this->post(route('legal-document.store'), [
            'title' => $title,
            'filename' => $filename,
            'user_id' => $user->id,
            'court_case_id' => $court_case->id,
            'document_type_id' => $document_type->id,
        ]);

        $legalDocuments = LegalDocument::query()
            ->where('title', $title)
            ->where('filename', $filename)
            ->where('user_id', $user->id)
            ->where('court_case_id', $court_case->id)
            ->where('document_type_id', $document_type->id)
            ->get();
        $this->assertCount(1, $legalDocuments);
        $legalDocument = $legalDocuments->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $legalDocument = LegalDocument::factory()->create();

        $response = $this->get(route('legal-document.show', $legalDocument));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\LegalDocumentController::class,
            'update',
            \App\Http\Requests\LegalDocumentUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $legalDocument = LegalDocument::factory()->create();
        $title = $this->faker->sentence(4);
        $filename = $this->faker->word;
        $user = User::factory()->create();
        $court_case = CourtCase::factory()->create();
        $document_type = LegalDocumentType::factory()->create();

        $response = $this->put(route('legal-document.update', $legalDocument), [
            'title' => $title,
            'filename' => $filename,
            'user_id' => $user->id,
            'court_case_id' => $court_case->id,
            'document_type_id' => $document_type->id,
        ]);

        $legalDocument->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($title, $legalDocument->title);
        $this->assertEquals($filename, $legalDocument->filename);
        $this->assertEquals($user->id, $legalDocument->user_id);
        $this->assertEquals($court_case->id, $legalDocument->court_case_id);
        $this->assertEquals($document_type->id, $legalDocument->document_type_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $legalDocument = LegalDocument::factory()->create();

        $response = $this->delete(route('legal-document.destroy', $legalDocument));

        $response->assertNoContent();

        $this->assertSoftDeleted($legalDocument);
    }
}
