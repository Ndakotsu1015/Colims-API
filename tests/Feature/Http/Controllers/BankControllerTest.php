<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Bank;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\BankController
 */
class BankControllerTest extends TestCase
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
        $banks = Bank::factory()->count(3)->create();

        $response = $this->get(route('bank.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\BankController::class,
            'store',
            \App\Http\Requests\BankStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $name = $this->faker->name;       
        $bank_code = $this->faker->word;

        $response = $this->post(route('bank.store'), [
            'name' => $name,            
            'bank_code' => $bank_code,
        ]);

        $banks = Bank::query()
            ->where('name', $name)            
            ->where('bank_code', $bank_code)
            ->get();
        $this->assertCount(1, $banks);
        $bank = $banks->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $bank = Bank::factory()->create();

        $response = $this->get(route('bank.show', $bank));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\BankController::class,
            'update',
            \App\Http\Requests\BankUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $bank = Bank::factory()->create();
        $name = $this->faker->name;        
        $bank_code = $this->faker->word;

        $response = $this->put(route('bank.update', $bank), [
            'name' => $name,            
            'bank_code' => $bank_code,
        ]);

        $bank->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $bank->name);       
        $this->assertEquals($bank_code, $bank->bank_code);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $bank = Bank::factory()->create();

        $response = $this->delete(route('bank.destroy', $bank));

        $response->assertNoContent();

        $this->assertSoftDeleted($bank);
    }
}
