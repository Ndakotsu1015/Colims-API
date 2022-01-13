<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Contractor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ContractorController
 */
class ContractorControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $contractors = Contractor::factory()->count(3)->create();

        $response = $this->get(route('contractor.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ContractorController::class,
            'store',
            \App\Http\Requests\ContractorStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $contractor_name = $this->faker->word;
        $address = $this->faker->word;
        $location = $this->faker->word;
        $email = $this->faker->safeEmail;
        $phone_no = $this->faker->word;
        $contact_name = $this->faker->word;
        $contact_email = $this->faker->word;
        $contact_phone = $this->faker->word;

        $response = $this->post(route('contractor.store'), [
            'contractor_name' => $contractor_name,
            'address' => $address,
            'location' => $location,
            'email' => $email,
            'phone_no' => $phone_no,
            'contact_name' => $contact_name,
            'contact_email' => $contact_email,
            'contact_phone' => $contact_phone,
        ]);

        $contractors = Contractor::query()
            ->where('contractor_name', $contractor_name)
            ->where('address', $address)
            ->where('location', $location)
            ->where('email', $email)
            ->where('phone_no', $phone_no)
            ->where('contact_name', $contact_name)
            ->where('contact_email', $contact_email)
            ->where('contact_phone', $contact_phone)
            ->get();
        $this->assertCount(1, $contractors);
        $contractor = $contractors->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $contractor = Contractor::factory()->create();

        $response = $this->get(route('contractor.show', $contractor));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ContractorController::class,
            'update',
            \App\Http\Requests\ContractorUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $contractor = Contractor::factory()->create();
        $contractor_name = $this->faker->word;
        $address = $this->faker->word;
        $location = $this->faker->word;
        $email = $this->faker->safeEmail;
        $phone_no = $this->faker->word;
        $contact_name = $this->faker->word;
        $contact_email = $this->faker->word;
        $contact_phone = $this->faker->word;

        $response = $this->put(route('contractor.update', $contractor), [
            'contractor_name' => $contractor_name,
            'address' => $address,
            'location' => $location,
            'email' => $email,
            'phone_no' => $phone_no,
            'contact_name' => $contact_name,
            'contact_email' => $contact_email,
            'contact_phone' => $contact_phone,
        ]);

        $contractor->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($contractor_name, $contractor->contractor_name);
        $this->assertEquals($address, $contractor->address);
        $this->assertEquals($location, $contractor->location);
        $this->assertEquals($email, $contractor->email);
        $this->assertEquals($phone_no, $contractor->phone_no);
        $this->assertEquals($contact_name, $contractor->contact_name);
        $this->assertEquals($contact_email, $contractor->contact_email);
        $this->assertEquals($contact_phone, $contractor->contact_phone);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $contractor = Contractor::factory()->create();

        $response = $this->delete(route('contractor.destroy', $contractor));

        $response->assertNoContent();

        $this->assertSoftDeleted($contractor);
    }
}
