<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\ContractDocumentType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ContractDocumentTypeController
 */
class ContractDocumentTypeControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $contractDocumentTypes = ContractDocumentType::factory()->count(3)->create();

        $response = $this->get(route('contract-document-type.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ContractDocumentTypeController::class,
            'store',
            \App\Http\Requests\ContractDocumentTypeStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $name = $this->faker->name;

        $response = $this->post(route('contract-document-type.store'), [
            'name' => $name,
        ]);

        $contractDocumentTypes = ContractDocumentType::query()
            ->where('name', $name)
            ->get();
        $this->assertCount(1, $contractDocumentTypes);
        $contractDocumentType = $contractDocumentTypes->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $contractDocumentType = ContractDocumentType::factory()->create();

        $response = $this->get(route('contract-document-type.show', $contractDocumentType));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ContractDocumentTypeController::class,
            'update',
            \App\Http\Requests\ContractDocumentTypeUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $contractDocumentType = ContractDocumentType::factory()->create();
        $name = $this->faker->name;

        $response = $this->put(route('contract-document-type.update', $contractDocumentType), [
            'name' => $name,
        ]);

        $contractDocumentType->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $contractDocumentType->name);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $contractDocumentType = ContractDocumentType::factory()->create();

        $response = $this->delete(route('contract-document-type.destroy', $contractDocumentType));

        $response->assertNoContent();

        $this->assertSoftDeleted($contractDocumentType);
    }
}
