<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_project(): void
    {
        $user = User::factory()->create();
        
        $userResponse = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $userResponse->assertStatus(200);

        $projectData = [
            'name' => 'Test Project',
            'description' => 'A test project description',
            'user_id' => $user->id,
        ];

        $response = $this->postJson('/api/projects', $projectData, ['Authorization' => 'Bearer ' . $userResponse->json('token')]);

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'data' => [
                        'id',
                        'name',
                        'description',
                        'user_id',
                        'created_at',
                        'updated_at',
                    ]
                ]);

        $this->assertDatabaseHas('projects', [
            'name' => 'Test Project',
            'user_id' => $user->id,
        ]);
    }

    public function test_can_list_projects(): void
    {
        $user = User::factory()->create();
        $userResponse = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $userResponse->assertStatus(200);
        
        Project::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->getJson('/api/projects', ['Authorization' => 'Bearer ' . $userResponse->json('token')]);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'description',
                            'tasks_count',
                        ]
                    ]
                ]);
    }

    // Add more test stubs for candidates to implement (OPTIONAL):
    // test_can_show_project_with_tasks()
    // test_project_validation_rules()
}
