<?php

namespace Tests\Feature\V1;

use App\Models\Marathon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Helpers\AuthServiceFakerHelper;
use Tests\Helpers\MarathonHelper;
use Tests\TestCase;

class MarathonTest extends TestCase
{
    use RefreshDatabase;

    public const RESOURCE_STRUCTURE = [
        'id', 'title', 'description', 'preview', 'start', 'end', 'status'
    ];

    /**
     * @return void
     */
    public function test_admin_can_see_list_of_marathons()
    {
        AuthServiceFakerHelper::actAsAdmin();

        Marathon::factory(10)->create();

        $response = $this->get('/api/v1/marathons');

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
    public function test_admin_can_add_new_marathon()
    {
        AuthServiceFakerHelper::actAsAdmin();

        $form = [
            'title' => 'My First Marathon',
            'description' => 'With some description',
            'start' => '2022-10-31 12:00:00',
            'end' => '2022-11-10 12:00:00',
        ];

        $response = $this->postJson('/api/v1/marathons', $form);

        $response->assertStatus(201)
            ->assertJson(['data' => $form])
            ->assertJsonStructure([
                'data' => self::RESOURCE_STRUCTURE
            ]);
    }

    /**
     * @return void
     */
    public function test_admin_can_see_marathon_info_by_id()
    {
        AuthServiceFakerHelper::actAsAdmin();

        $record = MarathonHelper::getOneRandom();

        $response = $this->getJson('/api/v1/marathons/' . $record->id);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => self::RESOURCE_STRUCTURE
            ]);
    }

    /**
     * @return void
     */
    public function test_admin_can_edit_marathon_by_id()
    {
        AuthServiceFakerHelper::actAsAdmin();

        $record = MarathonHelper::getOneRandom();

        $form = [
            'title' => 'My Updated Marathon',
            'description' => 'Some changed description',
            'start' => '2022-10-28 12:00:00',
            'end' => '2022-11-08 12:00:00',
        ];

        $response = $this->putJson('/api/v1/marathons/' . $record->id, $form);

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
    public function test_admin_can_delete_marathon_by_id()
    {
        AuthServiceFakerHelper::actAsAdmin();

        $record = MarathonHelper::getOneRandom();

        $response = $this->deleteJson('/api/v1/marathons/' . $record->id);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => self::RESOURCE_STRUCTURE
            ]);
    }

    /**
     * @return void
     */
    public function test_admin_with_role_guest_can_not_work_with_marathon_data()
    {
        AuthServiceFakerHelper::actAsAdminGuest();

        $record = MarathonHelper::getOneRandom();

        // Add
        $this->postJson('/api/v1/marathons')
            ->assertStatus(403);

        // Edit
        $this->putJson('/api/v1/marathons/' . $record->id)
            ->assertStatus(403);

        // Delete
        $this->deleteJson('/api/v1/marathons/' . $record->id)
            ->assertStatus(403);
    }

    /**
     * @return void
     */
    public function test_admin_with_role_guest_can_work_marathons_and_get_by_id_data()
    {
        AuthServiceFakerHelper::actAsAdminGuest();

        $record = MarathonHelper::getOneRandom();

        // List
        $this->getJson('/api/v1/marathons')
            ->assertStatus(200);

        // List
        $this->getJson('/api/v1/marathons/' . $record->id)
            ->assertStatus(200);
    }
}
