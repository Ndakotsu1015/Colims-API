<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\PropertyType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PropertyTypeController
 */
class PropertyTypeControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $propertyTypes = PropertyType::factory()->count(3)->create();

        $response = $this->get(route('property-type.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PropertyTypeController::class,
            'store',
            \App\Http\Requests\PropertyTypeStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $name = $this->faker->name;
        $property_code = $this->faker->word;

        $response = $this->post(route('property-type.store'), [
            'name' => $name,
            'property_code' => $property_code,
        ]);

        $propertyTypes = PropertyType::query()
            ->where('name', $name)
            ->where('property_code', $property_code)
            ->get();
        $this->assertCount(1, $propertyTypes);
        $propertyType = $propertyTypes->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $propertyType = PropertyType::factory()->create();

        $response = $this->get(route('property-type.show', $propertyType));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PropertyTypeController::class,
            'update',
            \App\Http\Requests\PropertyTypeUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $propertyType = PropertyType::factory()->create();
        $name = $this->faker->name;
        $property_code = $this->faker->word;

        $response = $this->put(route('property-type.update', $propertyType), [
            'name' => $name,
            'property_code' => $property_code,
        ]);

        $propertyType->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $propertyType->name);
        $this->assertEquals($property_code, $propertyType->property_code);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $propertyType = PropertyType::factory()->create();

        $response = $this->delete(route('property-type.destroy', $propertyType));

        $response->assertNoContent();

        $this->assertSoftDeleted($propertyType);
    }
}
