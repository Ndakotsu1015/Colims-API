<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\LegalDocumentType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\LegalDocumentTypeController
 */
class LegalDocumentTypeControllerTest extends TestCase
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
        $legalDocumentTypes = LegalDocumentType::factory()->count(3)->create();

        $response = $this->get(route('legal-document-type.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\LegalDocumentTypeController::class,
            'store',
            \App\Http\Requests\LegalDocumentTypeStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $name = $this->faker->name;

        $response = $this->post(route('legal-document-type.store'), [
            'name' => $name,
        ]);

        $legalDocumentTypes = LegalDocumentType::query()
            ->where('name', $name)
            ->get();
        $this->assertCount(1, $legalDocumentTypes);
        $legalDocumentType = $legalDocumentTypes->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $legalDocumentType = LegalDocumentType::factory()->create();

        $response = $this->get(route('legal-document-type.show', $legalDocumentType));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\LegalDocumentTypeController::class,
            'update',
            \App\Http\Requests\LegalDocumentTypeUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $legalDocumentType = LegalDocumentType::factory()->create();
        $name = $this->faker->name;

        $response = $this->put(route('legal-document-type.update', $legalDocumentType), [
            'name' => $name,
        ]);

        $legalDocumentType->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $legalDocumentType->name);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $legalDocumentType = LegalDocumentType::factory()->create();

        $response = $this->delete(route('legal-document-type.destroy', $legalDocumentType));

        $response->assertNoContent();

        $this->assertSoftDeleted($legalDocumentType);
    }
}
