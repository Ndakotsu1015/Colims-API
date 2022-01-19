<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Privilege;
use App\Models\PrivilegeClass;
use App\Models\PrivilegeDetail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PrivilegeDetailController
 */
class PrivilegeDetailControllerTest extends TestCase
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
        $privilegeDetails = PrivilegeDetail::factory()->count(3)->create();

        $response = $this->get(route('privilege-detail.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PrivilegeDetailController::class,
            'store',
            \App\Http\Requests\PrivilegeDetailStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $privilege_class = PrivilegeClass::factory()->create();
        $user = User::factory()->create();
        $privilege = Privilege::factory()->create();

        $response = $this->post(route('privilege-detail.store'), [
            'privilege_class_id' => $privilege_class->id,
            'user_id' => $user->id,
            'privilege_id' => $privilege->id,
        ]);

        $privilegeDetails = PrivilegeDetail::query()
            ->where('privilege_class_id', $privilege_class->id)
            ->where('user_id', $user->id)
            ->where('privilege_id', $privilege->id)
            ->get();
        $this->assertCount(1, $privilegeDetails);
        $privilegeDetail = $privilegeDetails->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $privilegeDetail = PrivilegeDetail::factory()->create();

        $response = $this->get(route('privilege-detail.show', $privilegeDetail));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PrivilegeDetailController::class,
            'update',
            \App\Http\Requests\PrivilegeDetailUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $privilegeDetail = PrivilegeDetail::factory()->create();
        $privilege_class = PrivilegeClass::factory()->create();
        $user = User::factory()->create();
        $privilege = Privilege::factory()->create();

        $response = $this->put(route('privilege-detail.update', $privilegeDetail), [
            'privilege_class_id' => $privilege_class->id,
            'user_id' => $user->id,
            'privilege_id' => $privilege->id,
        ]);

        $privilegeDetail->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($privilege_class->id, $privilegeDetail->privilege_class_id);
        $this->assertEquals($user->id, $privilegeDetail->user_id);
        $this->assertEquals($privilege->id, $privilegeDetail->privilege_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $privilegeDetail = PrivilegeDetail::factory()->create();

        $response = $this->delete(route('privilege-detail.destroy', $privilegeDetail));

        $response->assertNoContent();

        $this->assertSoftDeleted($privilegeDetail);
    }
}
