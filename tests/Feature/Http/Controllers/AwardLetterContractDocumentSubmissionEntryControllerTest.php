<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\AwardLetterContractDocumentSubmissionEntry;
use App\Models\Entry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AwardLetterContractDocumentSubmissionEntryController
 */
class AwardLetterContractDocumentSubmissionEntryControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $awardLetterContractDocumentSubmissionEntries = AwardLetterContractDocumentSubmissionEntry::factory()->count(3)->create();

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
            \App\Http\Controllers\AwardLetterContractDocumentSubmissionEntryController::class,
            'store',
            \App\Http\Requests\AwardLetterContractDocumentSubmissionEntryStoreRequest::class
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
        $entry = Entry::factory()->create();

        $response = $this->post(route('award-letter-contract-document-submission-entry.store'), [
            'name' => $name,
            'filename' => $filename,
            'is_approved' => $is_approved,
            'entry_id' => $entry->id,
        ]);

        $awardLetterContractDocumentSubmissionEntries = AwardLetterContractDocumentSubmissionEntry::query()
            ->where('name', $name)
            ->where('filename', $filename)
            ->where('is_approved', $is_approved)
            ->where('entry_id', $entry->id)
            ->get();
        $this->assertCount(1, $awardLetterContractDocumentSubmissionEntries);
        $awardLetterContractDocumentSubmissionEntry = $awardLetterContractDocumentSubmissionEntries->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $awardLetterContractDocumentSubmissionEntry = AwardLetterContractDocumentSubmissionEntry::factory()->create();

        $response = $this->get(route('award-letter-contract-document-submission-entry.show', $awardLetterContractDocumentSubmissionEntry));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AwardLetterContractDocumentSubmissionEntryController::class,
            'update',
            \App\Http\Requests\AwardLetterContractDocumentSubmissionEntryUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $awardLetterContractDocumentSubmissionEntry = AwardLetterContractDocumentSubmissionEntry::factory()->create();
        $name = $this->faker->name;
        $filename = $this->faker->word;
        $is_approved = $this->faker->boolean;
        $entry = Entry::factory()->create();

        $response = $this->put(route('award-letter-contract-document-submission-entry.update', $awardLetterContractDocumentSubmissionEntry), [
            'name' => $name,
            'filename' => $filename,
            'is_approved' => $is_approved,
            'entry_id' => $entry->id,
        ]);

        $awardLetterContractDocumentSubmissionEntry->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $awardLetterContractDocumentSubmissionEntry->name);
        $this->assertEquals($filename, $awardLetterContractDocumentSubmissionEntry->filename);
        $this->assertEquals($is_approved, $awardLetterContractDocumentSubmissionEntry->is_approved);
        $this->assertEquals($entry->id, $awardLetterContractDocumentSubmissionEntry->entry_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $awardLetterContractDocumentSubmissionEntry = AwardLetterContractDocumentSubmissionEntry::factory()->create();

        $response = $this->delete(route('award-letter-contract-document-submission-entry.destroy', $awardLetterContractDocumentSubmissionEntry));

        $response->assertNoContent();

        $this->assertSoftDeleted($awardLetterContractDocumentSubmissionEntry);
    }
}
