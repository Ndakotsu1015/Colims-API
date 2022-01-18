<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Privilege;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PrivilegeController
 */
class PrivilegeControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $privileges = Privilege::factory()->count(3)->create();

        $response = $this->get(route('privilege.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PrivilegeController::class,
            'store',
            \App\Http\Requests\PrivilegeStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $name = $this->faker->name;

        $response = $this->post(route('privilege.store'), [
            'name' => $name,
        ]);

        $privileges = Privilege::query()
            ->where('name', $name)
            ->get();
        $this->assertCount(1, $privileges);
        $privilege = $privileges->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $privilege = Privilege::factory()->create();

        $response = $this->get(route('privilege.show', $privilege));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PrivilegeController::class,
            'update',
            \App\Http\Requests\PrivilegeUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $privilege = Privilege::factory()->create();
        $name = $this->faker->name;

        $response = $this->put(route('privilege.update', $privilege), [
            'name' => $name,
        ]);

        $privilege->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $privilege->name);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $privilege = Privilege::factory()->create();

        $response = $this->delete(route('privilege.destroy', $privilege));

        $response->assertNoContent();

        $this->assertSoftDeleted($privilege);
    }
}
