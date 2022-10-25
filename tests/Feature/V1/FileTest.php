<?php

namespace Tests\Feature\V1;

use App\Services\TempFileService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Helpers\AuthServiceFakerHelper;
use Tests\TestCase;

class FileTest extends TestCase
{
    const RESOURCE_STRUCTURE = ['id', 'user_filename'];

    /**
     * @return void
     */
    public function test_admin_can_upload_file()
    {
        Storage::fake('local');

        AuthServiceFakerHelper::actAsAdmin();

        $file = UploadedFile::fake()->image('cover.jpg');

        $response = $this->postJson('/api/v1/files/upload', [
            'file' => $file,
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => self::RESOURCE_STRUCTURE
            ]);

        $path = TempFileService::TMP_FOLDER_NAME . DIRECTORY_SEPARATOR . $response->json('data.id');

        Storage::disk('local')->assertExists($path);
    }
}
