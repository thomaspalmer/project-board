<?php

namespace Tests\Feature\Tasks;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\Rules\Enum;
use Livewire\Livewire;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function create_task_is_on_every_page(): void
    {
        $this->user();

        $this->get(route('home'))
            ->assertSuccessful()
            ->assertSeeLivewire('tasks.create');

        $this->get(route('sources'))
            ->assertSuccessful()
            ->assertSeeLivewire('tasks.create');
    }

    /** @test */
    function create_task_is_successful(): void
    {
        $user = $this->user();

        Livewire::test('tasks.create')
            ->set('title', 'This is the task title')
            ->set('priority', 'low')
            ->set('due_at', $dueAt = now()->format("Y-m-d"))
            ->set('description', $description = 'This is a test task description')
            ->call('create')
            ->assertEmitted("taskWasCreated");

        $this->assertDatabaseHas('tasks', [
            'title' => 'This is the task title',
            'user_id' => $user->id,
            'priority' => 'low',
            'due_at' => $dueAt,
            'description' => $description,
        ]);
    }

    /** @test */
    function create_task_is_successful_with_minimal_input(): void
    {
        $user = $this->user();

        Livewire::test('tasks.create')
            ->set('title', 'This is the task title')
            ->call('create')
            ->assertEmitted("taskWasCreated");

        $this->assertDatabaseHas('tasks', [
            'title' => 'This is the task title',
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    function create_task_requires_a_title(): void
    {
        $this->user();

        Livewire::test('tasks.create')
            ->set('title', '')
            ->call('create')
            ->assertHasErrors([
                'title' => 'required',
            ]);
    }

    /** @test */
    function create_task_requires_a_priority(): void
    {
        $this->user();

        Livewire::test('tasks.create')
            ->set('title', 'The title')
            ->set('priority', '')
            ->call('create')
            ->assertHasErrors([
                'priority' => 'required',
            ]);
    }

    /** @test */
    function create_task_requires_due_at(): void
    {
        $this->user();

        Livewire::test('tasks.create')
            ->set('title', 'The title')
            ->set('due_at', '')
            ->call('create')
            ->assertHasErrors([
                'due_at' => 'required',
            ]);
    }

    /** @test */
    function create_task_requires_a_valid_priority(): void
    {
        $this->user();

        Livewire::test('tasks.create')
            ->set('title', 'The title')
            ->set('priority', 'not-a-valid-priority')
            ->call('create')
            ->assertHasErrors([
                'priority' => Enum::class,
            ]);
    }

    /** @test */
    function create_task_requires_a_valid_due_at_date(): void
    {
        $this->user();

        Livewire::test('tasks.create')
            ->set('title', 'The title')
            ->set('due_at', 'not-a-valid-date')
            ->call('create')
            ->assertHasErrors([
                'due_at' => 'date',
            ]);
    }
}
