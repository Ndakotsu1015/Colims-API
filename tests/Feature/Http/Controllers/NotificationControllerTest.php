<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\NotificationController
 */
class NotificationControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $notifications = Notification::factory()->count(3)->create();

        $response = $this->get(route('notification.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\NotificationController::class,
            'store',
            \App\Http\Requests\NotificationStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $user = User::factory()->create();
        $subject = $this->faker->word;
        $content = $this->faker->paragraphs(3, true);
        $is_read = $this->faker->boolean;

        $response = $this->post(route('notification.store'), [
            'user_id' => $user->id,
            'subject' => $subject,
            'content' => $content,
            'is_read' => $is_read,
        ]);

        $notifications = Notification::query()
            ->where('user_id', $user->id)
            ->where('subject', $subject)
            ->where('content', $content)
            ->where('is_read', $is_read)
            ->get();
        $this->assertCount(1, $notifications);
        $notification = $notifications->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $notification = Notification::factory()->create();

        $response = $this->get(route('notification.show', $notification));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\NotificationController::class,
            'update',
            \App\Http\Requests\NotificationUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $notification = Notification::factory()->create();
        $user = User::factory()->create();
        $subject = $this->faker->word;
        $content = $this->faker->paragraphs(3, true);
        $is_read = $this->faker->boolean;

        $response = $this->put(route('notification.update', $notification), [
            'user_id' => $user->id,
            'subject' => $subject,
            'content' => $content,
            'is_read' => $is_read,
        ]);

        $notification->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($user->id, $notification->user_id);
        $this->assertEquals($subject, $notification->subject);
        $this->assertEquals($content, $notification->content);
        $this->assertEquals($is_read, $notification->is_read);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $notification = Notification::factory()->create();

        $response = $this->delete(route('notification.destroy', $notification));

        $response->assertNoContent();

        $this->assertSoftDeleted($notification);
    }
}
