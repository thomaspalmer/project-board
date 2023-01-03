<?php

namespace Tests\Feature\Tasks;

use App\Models\{Task, User};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function delete_task_is_on_every_page(): void
    {
        $this->user();

        $this->get(route('home'))
            ->assertSuccessful()
            ->assertSeeLivewire('tasks.delete');

        $this->get(route('sources'))
            ->assertSuccessful()
            ->assertSeeLivewire('tasks.delete');
    }

    /** @test */
    function set_delete_task_is_successful(): void
    {
        $user = $this->user();

        $task = Task::factory()->for($user)->create();

        Livewire::test('tasks.delete')
            ->call('setDeleteTask', $task->id)
            ->assertEmitted("deleteTask");
    }

    /** @test */
    function delete_task_is_successful(): void
    {
        $user = $this->user();

        $task = Task::factory()->for($user)->create();

        Livewire::test('tasks.delete')
            ->call('setDeleteTask', $task->id)
            ->call('delete')
            ->assertEmitted("taskWasDeleted");

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }

    /** @test */
    function delete_task_cannot_delete_a_task_belonging_to_another_user(): void
    {
        $this->user();

        $task = Task::factory()->for(User::factory()->create())->create();

        Livewire::test('tasks.delete')
            ->call('setDeleteTask', $task->id)
            ->assertUnauthorized();
    }
}
