<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Bank;
use App\Models\ContractorAffliate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ContractorAffliateController
 */
class ContractorAffliateControllerTest extends TestCase
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
        $contractorAffliates = ContractorAffliate::factory()->count(3)->create();

        $response = $this->get(route('contractor-affliate.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ContractorAffliateController::class,
            'store',
            \App\Http\Requests\ContractorAffliateStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $name = $this->faker->name;
        $account_no = $this->faker->word;
        $account_officer = $this->faker->word;
        $account_officer_email = $this->faker->word;
        $bank_address = $this->faker->word;
        $sort_code = $this->faker->word;
        $bank = Bank::factory()->create();

        $response = $this->post(route('contractor-affliate.store'), [
            'name' => $name,
            'account_no' => $account_no,
            'account_officer' => $account_officer,
            'account_officer_email' => $account_officer_email,
            'bank_address' => $bank_address,
            'sort_code' => $sort_code,
            'bank_id' => $bank->id,
        ]);

        $contractorAffliates = ContractorAffliate::query()
            ->where('name', $name)
            ->where('account_no', $account_no)
            ->where('account_officer', $account_officer)
            ->where('account_officer_email', $account_officer_email)
            ->where('bank_address', $bank_address)
            ->where('sort_code', $sort_code)
            ->where('bank_id', $bank->id)
            ->get();
        $this->assertCount(1, $contractorAffliates);
        $contractorAffliate = $contractorAffliates->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $contractorAffliate = ContractorAffliate::factory()->create();

        $response = $this->get(route('contractor-affliate.show', $contractorAffliate));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ContractorAffliateController::class,
            'update',
            \App\Http\Requests\ContractorAffliateUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $contractorAffliate = ContractorAffliate::factory()->create();
        $name = $this->faker->name;
        $account_no = $this->faker->word;
        $account_officer = $this->faker->word;
        $account_officer_email = $this->faker->word;
        $bank_address = $this->faker->word;
        $sort_code = $this->faker->word;
        $bank = Bank::factory()->create();

        $response = $this->put(route('contractor-affliate.update', $contractorAffliate), [
            'name' => $name,
            'account_no' => $account_no,
            'account_officer' => $account_officer,
            'account_officer_email' => $account_officer_email,
            'bank_address' => $bank_address,
            'sort_code' => $sort_code,
            'bank_id' => $bank->id,
        ]);

        $contractorAffliate->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $contractorAffliate->name);
        $this->assertEquals($account_no, $contractorAffliate->account_no);
        $this->assertEquals($account_officer, $contractorAffliate->account_officer);
        $this->assertEquals($account_officer_email, $contractorAffliate->account_officer_email);
        $this->assertEquals($bank_address, $contractorAffliate->bank_address);
        $this->assertEquals($sort_code, $contractorAffliate->sort_code);
        $this->assertEquals($bank->id, $contractorAffliate->bank_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $contractorAffliate = ContractorAffliate::factory()->create();

        $response = $this->delete(route('contractor-affliate.destroy', $contractorAffliate));

        $response->assertNoContent();

        $this->assertSoftDeleted($contractorAffliate);
    }
}
