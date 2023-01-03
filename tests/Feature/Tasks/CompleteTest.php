<?php

namespace Tests\Feature\Tasks;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CompleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function complete_task_is_on_every_page(): void
    {
        $this->user();

        $this->get(route('home'))
            ->assertSuccessful()
            ->assertSeeLivewire('tasks.complete');

        $this->get(route('sources'))
            ->assertSuccessful()
            ->assertSeeLivewire('tasks.complete');
    }

    /** @test */
    function set_complete_task_is_successful(): void
    {
        $user = $this->user();

        $task = Task::factory()->for($user)->create();

        Livewire::test('tasks.complete')
            ->call('setCompleteTask', $task->id)
            ->assertEmitted("completeTask");
    }

    /** @test */
    function complete_task_is_successful(): void
    {
        $user = $this->user();

        $task = Task::factory()->for($user)->create([
            'completed_at' => null,
        ]);

        Livewire::test('tasks.complete')
            ->call('setCompleteTask', $task->id)
            ->call('update')
            ->assertEmitted("taskWasUpdated");

        $task = Task::findOrFail($task->id);
        $this->assertTrue($task->completed_at !== null);
    }

    /** @test */
    function complete_task_cannot_update_a_task_belonging_to_another_user(): void
    {
        $this->user();

        $task = Task::factory()->for(User::factory()->create())->create();

        Livewire::test('tasks.complete')
            ->call('setCompleteTask', $task->id)
            ->assertUnauthorized();
    }
}
