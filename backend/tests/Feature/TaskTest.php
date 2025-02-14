<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase; // Garante que o banco de dados seja limpo a cada teste

    protected function authenticate()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        return [
            'Authorization' => "Bearer $token",
            'Accept' => 'application/json'
        ];
    }

    public function test_user_can_load_tasks()
    {
        $user = User::factory()->create();
        Task::factory(5)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->getJson(route('load'));

        $response->assertStatus(200)
                 ->assertJsonCount(5);
    }

    public function test_user_can_create_a_task()
    {
        $user = User::factory()->create();
        $taskData = [
            'title' => 'Nova Tarefa',
            'description' => 'Descrição da tarefa',
            'status' => 'pending'
        ];

        $response = $this->actingAs($user)->postJson(route('store'), $taskData);

        $response->assertStatus(201)
                 ->assertJsonFragment(['title' => 'Nova Tarefa']);
    }

    public function test_user_can_update_a_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $updateData = [
            'title' => 'Título Atualizado',
            'description' => 'Descrição Atualizada',
            'status' => 'underway'
        ];

        $response = $this->actingAs($user)->putJson(route('update', $task->id), $updateData);

        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => 'Título Atualizado']);
    }

    public function test_user_cannot_update_task_of_another_user()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user1->id]);

        $response = $this->actingAs($user2)->putJson(route('update', $task->id), [
            'title' => 'Tentativa de alteração',
            'description' => 'Tentativa de alteração',
            'status' => 'finish'
        ]);

        $response->assertStatus(403);
    }

    public function test_user_can_delete_a_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->deleteJson(route('delete', $task->id));

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Tarefa excluída com sucesso.']);
    }

    public function test_user_cannot_delete_task_of_another_user()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user1->id]);

        $response = $this->actingAs($user2)->deleteJson(route('delete', $task->id));

        $response->assertStatus(403);
    }

    public function test_user_cannot_update_non_existent_task()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson(route('update', 999), [
            'title' => 'Nova tentativa',
            'description' => 'Nova tentativa',
            'status' => 'pending'
        ]);

        $response->assertStatus(404);
    }
}
