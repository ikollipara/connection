<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Http\Client\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class FileUploadControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_store_file()
    {
        Storage::fake("public");
        $data = [
            "image" => UploadedFile::fake()->image("image.jpg"),
        ];

        $response = $this->actingAs($this->user)->post(route("upload.store"), $data);
        $response->assertJsonStructure(["success", "file" => ["url"]]);
        $response->assertJsonFragment([
            "success" => 1,
        ]);

        Storage::disk("public")->assertExists("files/" . $data["image"]->hashName());
    }

    public function test_store_url()
    {
        Storage::fake("public");
        $data = [
            "url" => "https://picsum.photos/{$this->faker->numberBetween(200, 300)}/{$this->faker->numberBetween(
                200,
                300,
            )}",
        ];

        $response = $this->actingAs($this->user)->post(route("upload.store"), $data);
        $response->assertJsonStructure(["success", "file" => ["url"]]);
        $response->assertJsonFragment([
            "success" => 1,
        ]);
        Storage::disk("public")->assertExists("files/" . str($response->json("file")["url"])->afterLast("/"));
    }

    public function test_delete_upload()
    {
        Storage::fake("public");
        $file = UploadedFile::fake()->image("image.jpg");
        $path = $file->store("files", "public");

        $response = $this->actingAs($this->user)->delete(route("upload.destroy"), ["path" => $path]);
        Storage::disk("public")->assertMissing($path);
    }

    public function test_delete_upload_from_storage_url()
    {
        Storage::fake("public");
        $file = UploadedFile::fake()->image("image.jpg");
        $path = Storage::url($file->store("files", "public"));

        $response = $this->actingAs($this->user)->delete(route("upload.destroy"), ["path" => $path]);
        Storage::disk("public")->assertMissing($path);
    }
}
