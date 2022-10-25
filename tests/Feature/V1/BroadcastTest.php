<?php

namespace Tests\Feature\V1;

use App\Models\Broadcast;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Helpers\AuthServiceFakerHelper;
use Tests\Helpers\BroadcastHelper;
use Tests\TestCase;

class BroadcastTest extends TestCase
{
    use RefreshDatabase;

    public const RESOURCE_STRUCTURE = [
        'id', 'title', 'marathon'
    ];

    /**
     * @return void
     */
    public function test_admin_can_see_list_of_broadcasts()
    {
        AuthServiceFakerHelper::actAsAdmin();

        Broadcast::factory(10)->create();

        $response = $this->get('/api/v1/broadcasts');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'links', 'meta'])
            ->assertJsonStructure([
                'data' => [
                    '*' => self::RESOURCE_STRUCTURE
                ]
            ]);
    }

    /**
     * @return void
     */
    public function test_admin_can_add_new_broadcast()
    {
        AuthServiceFakerHelper::actAsAdmin();

        $form = [
            'title' => 'My First Broadcast'
        ];

        $response = $this->postJson('/api/v1/broadcasts', $form);

        $response->assertStatus(201)
            ->assertJson(['data' => $form])
            ->assertJsonStructure([
                'data' => self::RESOURCE_STRUCTURE
            ]);
    }

    /**
     * @return void
     */
    public function test_admin_can_see_broadcast_info_by_id()
    {
        AuthServiceFakerHelper::actAsAdmin();

        $record = BroadcastHelper::getOneRandom();

        $response = $this->getJson('/api/v1/broadcasts/' . $record->id);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => self::RESOURCE_STRUCTURE
            ]);
    }

    /**
     * @return void
     */
    public function test_admin_can_edit_broadcast_by_id()
    {
        AuthServiceFakerHelper::actAsAdmin();

        $record = BroadcastHelper::getOneRandom();

        $form = [
            'title' => 'My Updated Broadcast'
        ];

        $response = $this->putJson('/api/v1/broadcasts/' . $record->id, $form);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => self::RESOURCE_STRUCTURE
            ])
            ->assertJsonPath('data.title', $form['title'])
            ->assertJsonPath('data.id', $record->id);
    }

    /**
     * @return void
     */
    public function test_admin_can_delete_broadcast_by_id()
    {
        AuthServiceFakerHelper::actAsAdmin();

        $record = BroadcastHelper::getOneRandom();

        $response = $this->deleteJson('/api/v1/broadcasts/' . $record->id);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => self::RESOURCE_STRUCTURE
            ]);
    }
}
