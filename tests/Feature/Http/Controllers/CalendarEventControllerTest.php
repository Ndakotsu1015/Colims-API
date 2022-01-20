<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\CalendarEvent;
use App\Models\CourtCase;
use App\Models\PostedBy;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CalendarEventController
 */
class CalendarEventControllerTest extends TestCase
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
        $calendarEvents = CalendarEvent::factory()->count(3)->create();

        $response = $this->get(route('calendar-event.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CalendarEventController::class,
            'store',
            \App\Http\Requests\CalendarEventStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $description = $this->faker->text;
        $location = $this->faker->word;
        $start_time = $this->faker->dateTime();
        $end_time = $this->faker->dateTime();
        $posted_by = User::factory()->create();
        $court_case = CourtCase::factory()->create();

        $response = $this->post(route('calendar-event.store'), [
            'description' => $description,
            'location' => $location,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'posted_by' => $posted_by->id,
            'court_case_id' => $court_case->id,
        ]);

        $calendarEvents = CalendarEvent::query()
            ->where('description', $description)
            ->where('location', $location)
            ->where('start_time', $start_time)
            ->where('end_time', $end_time)
            ->where('posted_by', $posted_by->id)
            ->where('court_case_id', $court_case->id)
            ->get();
        $this->assertCount(1, $calendarEvents);
        $calendarEvent = $calendarEvents->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $calendarEvent = CalendarEvent::factory()->create();

        $response = $this->get(route('calendar-event.show', $calendarEvent));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CalendarEventController::class,
            'update',
            \App\Http\Requests\CalendarEventUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $calendarEvent = CalendarEvent::factory()->create();
        $description = $this->faker->text;
        $location = $this->faker->word;
        $start_time = $this->faker->dateTime();
        $end_time = $this->faker->dateTime();
        $posted_by = User::factory()->create();
        $court_case = CourtCase::factory()->create();

        $response = $this->put(route('calendar-event.update', $calendarEvent), [
            'description' => $description,
            'location' => $location,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'posted_by' => $posted_by->id,
            'court_case_id' => $court_case->id,
        ]);

        $calendarEvent->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($description, $calendarEvent->description);
        $this->assertEquals($location, $calendarEvent->location);
        $this->assertEquals($start_time, $calendarEvent->start_time);
        $this->assertEquals($end_time, $calendarEvent->end_time);
        $this->assertEquals($posted_by->id, $calendarEvent->posted_by);
        $this->assertEquals($court_case->id, $calendarEvent->court_case_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $calendarEvent = CalendarEvent::factory()->create();

        $response = $this->delete(route('calendar-event.destroy', $calendarEvent));

        $response->assertNoContent();

        $this->assertSoftDeleted($calendarEvent);
    }
}
