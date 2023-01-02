<?php

namespace Tests\Feature\Source;

use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;
use App\Models\Source;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function create_page_requires_authenticated_user(): void
    {
        $this->get(route('sources.create'))
            ->assertRedirectToRoute('login');
    }

    /** @test */
    function create_page_contains_livewire_component(): void
    {
        $this->user();

        $this->get(route('sources.create'))
            ->assertSuccessful()
            ->assertSeeLivewire('sources.create');
    }

    /** @test */
    function a_source_for_active_collab_can_be_created(): void
    {
        $this->user();

        Livewire::test('sources.create')
            ->set('name', 'Active Collab Test')
            ->set('vendor', 'active-collab')
            ->set('credentials.company_name', 'Test Company Name')
            ->set('credentials.email', 'test@test.com')
            ->set('credentials.password', 'password')
            ->set('credentials.account_number', '123456789')
            ->call('create')
            ->assertRedirect(route('sources'));

        $this->assertTrue(Source::where([
            ['name', 'Active Collab Test'],
            ['vendor', 'active-collab'],
        ])->exists());
    }

    /** @test */
    function a_source_for_github_can_be_created(): void
    {
        $this->user();

        Livewire::test('sources.create')
            ->set('name', 'GitHub Test')
            ->set('vendor', 'github')
            ->set('credentials.personal_access_token', Str::random(32))
            ->set('credentials.expires_at', now()->format("Y-m-d H:i:s"))
            ->call('create')
            ->assertRedirect(route('sources'));

        $this->assertTrue(Source::where([
            ['name', 'GitHub Test'],
            ['vendor', 'github'],
        ])->exists());
    }

    /** @test */
    function name_is_required(): void
    {
        $this->user();

        Livewire::test('sources.create')
            ->set('name', '')
            ->set('vendor', 'github')
            ->set('credentials.personal_access_token', Str::random(32))
            ->set('credentials.expires_at', now()->format("Y-m-d H:i:s"))
            ->call('create')
            ->assertHasErrors(['name' => 'required']);
    }

    /** @test */
    function vendor_is_required(): void
    {
        $this->user();

        Livewire::test('sources.create')
            ->set('name', 'Test')
            ->set('vendor', '')
            ->call('create')
            ->assertHasErrors(['vendor' => 'required']);
    }

    /** @test */
    function vendor_acceptance(): void
    {
        $this->user();

        Livewire::test('sources.create')
            ->set('name', 'Test')
            ->set('vendor', 'not-a-valid-vendor')
            ->call('create')
            ->assertHasErrors(['vendor' => Enum::class]);
    }

    /** @test */
    function personal_access_token_is_required_for_github(): void
    {
        $this->user();

        Livewire::test('sources.create')
            ->set('name', 'github-test')
            ->set('vendor', 'github')
            ->set('credentials.personal_access_token', '')
            ->set('credentials.expires_at', now()->format("Y-m-d H:i:s"))
            ->call('create')
            ->assertHasErrors(['credentials.personal_access_token' => 'required_if']);
    }

    /** @test */
    function expires_at_is_required_for_github(): void
    {
        $this->user();

        Livewire::test('sources.create')
            ->set('name', 'github-test')
            ->set('vendor', 'github')
            ->set('credentials.personal_access_token', Str::random(32))
            ->set('credentials.expires_at', '')
            ->call('create')
            ->assertHasErrors(['credentials.expires_at' => 'required_if']);
    }

    /** @test */
    function expires_at_must_be_a_date_for_github(): void
    {
        $this->user();

        Livewire::test('sources.create')
            ->set('name', 'github-test')
            ->set('vendor', 'github')
            ->set('credentials.personal_access_token', Str::random(32))
            ->set('credentials.expires_at', 'string-value')
            ->call('create')
            ->assertHasErrors(['credentials.expires_at' => 'date']);
    }

    /** @test */
    function company_name_is_required_for_active_collab(): void
    {
        $this->user();

        Livewire::test('sources.create')
            ->set('name', 'active-collab-test')
            ->set('vendor', 'active-collab')
            ->set('credentials.company_name', '')
            ->set('credentials.email', 'test@test.com')
            ->set('credentials.password', 'password')
            ->set('credentials.account_number', '123456789')
            ->call('create')
            ->assertHasErrors(['credentials.company_name' => 'required_if']);
    }

    /** @test */
    function email_is_required_for_active_collab(): void
    {
        $this->user();

        Livewire::test('sources.create')
            ->set('name', 'active-collab-test')
            ->set('vendor', 'active-collab')
            ->set('credentials.company_name', 'test Company')
            ->set('credentials.email', '')
            ->set('credentials.password', 'password')
            ->set('credentials.account_number', '123456789')
            ->call('create')
            ->assertHasErrors(['credentials.email' => 'required_if']);
    }

    /** @test */
    function email_must_be_a_email_for_active_collab(): void
    {
        $this->user();

        Livewire::test('sources.create')
            ->set('name', 'active-collab-test')
            ->set('vendor', 'active-collab')
            ->set('credentials.company_name', 'test Company')
            ->set('credentials.email', 'notanemail')
            ->set('credentials.password', 'password')
            ->set('credentials.account_number', '123456789')
            ->call('create')
            ->assertHasErrors(['credentials.email' => 'email']);
    }

    /** @test */
    function password_is_required_for_active_collab(): void
    {
        $this->user();

        Livewire::test('sources.create')
            ->set('name', 'active-collab-test')
            ->set('vendor', 'active-collab')
            ->set('credentials.company_name', 'test Company')
            ->set('credentials.email', 'test@test.com')
            ->set('credentials.password', '')
            ->set('credentials.account_number', '123456789')
            ->call('create')
            ->assertHasErrors(['credentials.password' => 'required_if']);
    }

    /** @test */
    function account_number_is_required_for_active_collab(): void
    {
        $this->user();

        Livewire::test('sources.create')
            ->set('name', 'active-collab-test')
            ->set('vendor', 'active-collab')
            ->set('credentials.company_name', 'test Company')
            ->set('credentials.email', 'test@test.com')
            ->set('credentials.password', 'password')
            ->set('credentials.account_number', '')
            ->call('create')
            ->assertHasErrors(['credentials.account_number' => 'required_if']);
    }
}
