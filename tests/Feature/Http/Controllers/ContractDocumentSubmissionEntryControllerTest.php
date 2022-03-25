<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\ContractDocumentSubmissionEntry;
use App\Models\Entry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ContractDocumentSubmissionEntryController
 */
class ContractDocumentSubmissionEntryControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $ContractDocumentSubmissionEntries = ContractDocumentSubmissionEntry::factory()->count(3)->create();

        $response = $this->get(route('award-letter-contract-document-submission-entry.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ContractDocumentSubmissionEntryController::class,
            'store',
            \App\Http\Requests\ContractDocumentSubmissionEntryStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $name = $this->faker->name;
        $filename = $this->faker->word;
        $is_approved = $this->faker->boolean;
        $entry = ContractDocumentSubmissionEntry::factory()->create();

        $response = $this->post(route('award-letter-contract-document-submission-entry.store'), [
            'name' => $name,
            'filename' => $filename,
            'is_approved' => $is_approved,
            'entry_id' => $entry->id,
            'document_type_id' => $entry->document_type_id,
        ]);

        $ContractDocumentSubmissionEntries = ContractDocumentSubmissionEntry::query()
            ->where('name', $name)
            ->where('filename', $filename)
            ->where('is_approved', $is_approved)
            ->where('entry_id', $entry->id)
            ->where('document_type_id', $entry->document_type_id)
            ->get();
        $this->assertCount(1, $ContractDocumentSubmissionEntries);
        $ContractDocumentSubmissionEntry = $ContractDocumentSubmissionEntries->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $ContractDocumentSubmissionEntry = ContractDocumentSubmissionEntry::factory()->create();

        $response = $this->get(route('award-letter-contract-document-submission-entry.show', $ContractDocumentSubmissionEntry));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ContractDocumentSubmissionEntryController::class,
            'update',
            \App\Http\Requests\ContractDocumentSubmissionEntryUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $ContractDocumentSubmissionEntry = ContractDocumentSubmissionEntry::factory()->create();
        $name = $this->faker->name;
        $filename = $this->faker->word;
        $is_approved = $this->faker->boolean;
        $entry = ContractDocumentSubmissionEntry::factory()->create();

        $response = $this->put(route('award-letter-contract-document-submission-entry.update', $ContractDocumentSubmissionEntry), [
            'name' => $name,
            'filename' => $filename,
            'is_approved' => $is_approved,
            'entry_id' => $entry->id,
            'document_type_id' => $entry->document_type_id,
        ]);

        $ContractDocumentSubmissionEntry->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $ContractDocumentSubmissionEntry->name);
        $this->assertEquals($filename, $ContractDocumentSubmissionEntry->filename);
        $this->assertEquals($is_approved, $ContractDocumentSubmissionEntry->is_approved);
        $this->assertEquals($entry->id, $ContractDocumentSubmissionEntry->entry_id);
        $this->assertEquals($entry->document_type_id, $ContractDocumentSubmissionEntry->document_type_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $ContractDocumentSubmissionEntry = ContractDocumentSubmissionEntry::factory()->create();

        $response = $this->delete(route('award-letter-contract-document-submission-entry.destroy', $ContractDocumentSubmissionEntry));

        $response->assertNoContent();

        $this->assertSoftDeleted($ContractDocumentSubmissionEntry);
    }
}
