<?php

namespace Tests\Feature\Tasks;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\Rules\Enum;
use Livewire\Livewire;
use Tests\TestCase;

class EditTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function edit_task_is_on_every_page(): void
    {
        $this->user();

        $this->get(route('home'))
            ->assertSuccessful()
            ->assertSeeLivewire('tasks.edit');

        $this->get(route('sources'))
            ->assertSuccessful()
            ->assertSeeLivewire('tasks.edit');
    }

    /** @test */
    function set_edit_task_is_successful(): void
    {
        $user = $this->user();

        $task = Task::factory()->for($user)->create();

        Livewire::test('tasks.edit')
            ->call('setEditTask', $task->id)
            ->assertEmitted("editTask");
    }

    /** @test */
    function edit_task_is_successful(): void
    {
        $user = $this->user();

        $task = Task::factory()->for($user)->create();

        Livewire::test('tasks.edit')
            ->call('setEditTask', $task->id)
            ->set('title', 'This is the task title')
            ->set('priority', 'low')
            ->set('due_at', $dueAt = now()->format("Y-m-d"))
            ->set('description', $description = 'This is a test task description')
            ->call('update')
            ->assertEmitted("taskWasUpdated");

        $this->assertDatabaseHas('tasks', [
            'title' => 'This is the task title',
            'user_id' => $user->id,
            'priority' => 'low',
            'due_at' => $dueAt,
            'description' => $description,
        ]);
    }

    /** @test */
    function edit_task_is_successful_with_minimal_input(): void
    {
        $user = $this->user();

        $task = Task::factory()->for($user)->create();

        Livewire::test('tasks.edit')
            ->call('setEditTask', $task->id)
            ->set('title', 'This is the task title')
            ->call('update')
            ->assertEmitted("taskWasUpdated");

        $this->assertDatabaseHas('tasks', [
            'title' => 'This is the task title',
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    function edit_task_cannot_update_a_task_belonging_to_another_user(): void
    {
        $this->user();

        $task = Task::factory()->for(User::factory()->create())->create();

        Livewire::test('tasks.edit')
            ->call('setEditTask', $task->id)
            ->assertUnauthorized();
    }

    /** @test */
    function edit_task_requires_a_title(): void
    {
        $user = $this->user();

        $task = Task::factory()->for($user)->create();

        Livewire::test('tasks.edit')
            ->call('setEditTask', $task->id)
            ->set('title', '')
            ->call('update')
            ->assertHasErrors([
                'title' => 'required',
            ]);
    }

    /** @test */
    function edit_task_requires_a_priority(): void
    {
        $user = $this->user();

        $task = Task::factory()->for($user)->create();

        Livewire::test('tasks.edit')
            ->call('setEditTask', $task->id)
            ->set('title', 'The title')
            ->set('priority', '')
            ->call('update')
            ->assertHasErrors([
                'priority' => 'required',
            ]);
    }

    /** @test */
    function edit_task_requires_due_at(): void
    {
        $user = $this->user();

        $task = Task::factory()->for($user)->create();

        Livewire::test('tasks.edit')
            ->call('setEditTask', $task->id)
            ->set('title', 'The title')
            ->set('due_at', '')
            ->call('update')
            ->assertHasErrors([
                'due_at' => 'required',
            ]);
    }

    /** @test */
    function edit_task_requires_a_valid_priority(): void
    {
        $user = $this->user();

        $task = Task::factory()->for($user)->create();

        Livewire::test('tasks.edit')
            ->call('setEditTask', $task->id)
            ->set('title', 'The title')
            ->set('priority', 'not-a-valid-priority')
            ->call('update')
            ->assertHasErrors([
                'priority' => Enum::class,
            ]);
    }

    /** @test */
    function edit_task_requires_a_valid_due_at_date(): void
    {
        $user = $this->user();

        $task = Task::factory()->for($user)->create();

        Livewire::test('tasks.edit')
            ->call('setEditTask', $task->id)
            ->set('title', 'The title')
            ->set('due_at', 'not-a-valid-date')
            ->call('update')
            ->assertHasErrors([
                'due_at' => 'date',
            ]);
    }
}
