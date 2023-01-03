<?php

namespace Tests\Feature\Source;

use App\Models\Source;
use App\Models\User;
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
            ->assertSeeLivewire('sources.index')
            ->assertSeeLivewire('sources.delete');
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

    /** @test */
    function source_page_cannot_update_source_belonging_to_another_user(): void
    {
        $this->user();

        $source = Source::factory()->for(User::factory()->create())->create([
            'active' => false,
        ]);

        Livewire::test("sources.index")
            ->call('toggleActive', $source->id)
            ->assertUnauthorized();
    }

    /** @test */
    public function source_page_correctly_inits_delete_confirmation(): void
    {
        $user = $this->user();

        $source = Source::factory()->for($user)->create();

        Livewire::test("sources.delete")
            ->call("setDeleteSource", $source->id)
            ->assertEmitted("deleteSourceConfirm");
    }

    /** @test */
    public function source_page_can_delete_a_source(): void
    {
        $user = $this->user();

        $source = Source::factory()->for($user)->create();

        Livewire::test("sources.delete")
            ->call("setDeleteSource", $source->id)
            ->call("delete")
            ->assertEmitted("sourceWasDeleted");

        $this->assertDatabaseMissing('sources', [
            'id' => $source->id,
        ]);
    }

    /** @test */
    public function source_page_cannot_delete_a_source_belonging_to_another_user(): void
    {
        $this->user();

        $source = Source::factory()->for(User::factory()->create())->create();

        Livewire::test("sources.delete")
            ->call("setDeleteSource", $source->id)
            ->assertUnauthorized();

        $this->assertDatabaseHas('sources', [
            'id' => $source->id,
        ]);
    }
}
