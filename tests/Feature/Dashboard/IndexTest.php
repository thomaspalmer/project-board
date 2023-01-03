<?php

namespace Tests\Feature\Dashboard;

use Livewire\Livewire;
use App\Models\{Source, Task};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function dashboard_page_requires_authenticated_user(): void
    {
        $this->get(route('home'))
            ->assertRedirectToRoute('login');
    }

    /** @test */
    function dashboard_page_contains_livewire_component(): void
    {
        $this->user();

        $this->get(route('home'))
            ->assertSuccessful()
            ->assertSeeLivewire('dashboard.index')
            ->assertSeeLivewire('dashboard.current-priority')
            ->assertSeeLivewire('dashboard.next-priority')
            ->assertSeeLivewire('dashboard.backlog');
    }

    /** @test */
    function dashboard_page_shows_current_priority(): void
    {
        $user = $this->user();

        $source = Source::factory()->for($user)->create([
            'active' => true,
        ]);

        Task::factory()->count(10)->for($user)->for($source)->create();

        $tasks = $user->tasks()->priorityOrder()->get();

        Livewire::test('dashboard.index')
            ->assertSuccessful()
            ->assertSeeHtml(
                view('livewire.dashboard.current-priority', ['task' => $tasks->first()])->render()
            );
    }

    /** @test */
    function dashboard_page_shows_next_priority(): void
    {
        $user = $this->user();

        $source = Source::factory()->for($user)->create([
            'active' => true,
        ]);

        Task::factory()->count(10)->for($user)->for($source)->create();

        $tasks = $user->tasks()->priorityOrder()->get();

        Livewire::test('dashboard.index')
            ->assertSuccessful()
            ->assertSeeHtml(view(
                'livewire.dashboard.next-priority', ['task' => $tasks->slice(1, 1)->first()])->render()
            );
    }

    /** @test */
    function dashboard_page_shows_a_backlog(): void
    {
        $user = $this->user();

        $source = Source::factory()->for($user)->create([
            'active' => true,
        ]);

        Task::factory()->count(10)->for($user)->for($source)->create();

        $tasks = $user->tasks()->priorityOrder()->get();

        Livewire::test('dashboard.index')
            ->assertSuccessful()
            ->assertSeeHtml(view(
                'livewire.dashboard.backlog', ['tasks' => $tasks->slice(2)]
            )->render());
    }

}
