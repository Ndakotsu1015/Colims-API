<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\AwardLetter;
use App\Models\AwardLetterInternalDocument;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AwardLetterInternalDocumentController
 */
class AwardLetterInternalDocumentControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $awardLetterInternalDocuments = AwardLetterInternalDocument::factory()->count(3)->create();

        $response = $this->get(route('award-letter-internal-document.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AwardLetterInternalDocumentController::class,
            'store',
            \App\Http\Requests\AwardLetterInternalDocumentStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $name = $this->faker->name;
        $filename = $this->faker->word;
        $award_letter = AwardLetter::factory()->create();

        $response = $this->post(route('award-letter-internal-document.store'), [
            'name' => $name,
            'filename' => $filename,
            'award_letter_id' => $award_letter->id,
        ]);

        $awardLetterInternalDocuments = AwardLetterInternalDocument::query()
            ->where('name', $name)
            ->where('filename', $filename)
            ->where('award_letter_id', $award_letter->id)
            ->get();
        $this->assertCount(1, $awardLetterInternalDocuments);
        $awardLetterInternalDocument = $awardLetterInternalDocuments->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $awardLetterInternalDocument = AwardLetterInternalDocument::factory()->create();

        $response = $this->get(route('award-letter-internal-document.show', $awardLetterInternalDocument));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AwardLetterInternalDocumentController::class,
            'update',
            \App\Http\Requests\AwardLetterInternalDocumentUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $awardLetterInternalDocument = AwardLetterInternalDocument::factory()->create();
        $name = $this->faker->name;
        $filename = $this->faker->word;
        $award_letter = AwardLetter::factory()->create();

        $response = $this->put(route('award-letter-internal-document.update', $awardLetterInternalDocument), [
            'name' => $name,
            'filename' => $filename,
            'award_letter_id' => $award_letter->id,
        ]);

        $awardLetterInternalDocument->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $awardLetterInternalDocument->name);
        $this->assertEquals($filename, $awardLetterInternalDocument->filename);
        $this->assertEquals($award_letter->id, $awardLetterInternalDocument->award_letter_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $awardLetterInternalDocument = AwardLetterInternalDocument::factory()->create();

        $response = $this->delete(route('award-letter-internal-document.destroy', $awardLetterInternalDocument));

        $response->assertNoContent();

        $this->assertSoftDeleted($awardLetterInternalDocument);
    }
}
