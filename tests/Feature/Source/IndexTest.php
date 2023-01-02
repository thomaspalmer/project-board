<?php

namespace Tests\Feature\Source;

use App\Models\Source;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function source_page_requires_authenticated_user(): void
    {
        $this->get(route('sources'))
            ->assertRedirectToRoute('login');
    }

    /** @test */
    function source_page_contains_livewire_component(): void
    {
        $this->user();

        $this->get(route('sources'))
            ->assertSuccessful()
            ->assertSeeLivewire('sources.index');
    }

    /** @test */
    function source_page_lists_sources(): void
    {
        $user = $this->user();

        $sources = Source::factory()->count(10)->for($user)->create();

        Livewire::test("sources.index")
            ->assertSee($sources->first()->name)
            ->assertSee($sources->last()->name);
    }

    /** @test */
    function source_page_can_disable_source(): void
    {
        $user = $this->user();

        $source = Source::factory()->for($user)->create([
            'active' => true,
        ]);

        Livewire::test("sources.index")
            ->assertSee("Yes")
            ->call('toggleActive', $source->id)
            ->assertSee("No");
    }

    /** @test */
    function source_page_can_enable_source(): void
    {
        $user = $this->user();

        $source = Source::factory()->for($user)->create([
            'active' => false,
        ]);

        Livewire::test("sources.index")
            ->assertSee("No")
            ->call('toggleActive', $source->id)
            ->assertSee("Yes");
    }
}
