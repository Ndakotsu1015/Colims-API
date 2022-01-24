<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class FileUploadControllerTest extends TestCase
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
     *
     * @return void
     */
    public function upload_file()
    {
        Storage::fake('local');
        $this->withoutExceptionHandling();
        $this->actingAs($this->user)->post(route('file.upload'),  [
            'file' => $file = UploadedFile::fake()->image('random.jpg'),
            'visibility' => $visibility = $this->faker->randomElement(['private', 'public'])
        ])->assertOk()
          ->assertJsonStructure([]);
 
        $path = $visibility == 'private' ? 'files/' : 'public/files/';
        Storage::disk('local')->assertExists($path .$file->hashName());
    }

    /**
     * @test
     *
     * @return void
     */
    public function get_file()
    {
        Storage::fake('local');
        $filename = explode('/', UploadedFile::fake()->image('random.jpg')->store('files'))[1];
        $visibility = 'private';
        $this->withoutExceptionHandling();
        $this->get(route('file.get',['filename' => $filename, 'visibility' => $visibility]))->assertOk();
 
    }
}
