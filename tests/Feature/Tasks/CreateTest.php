<?php

namespace Tests\Feature\Tasks;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function create_page_is_on_every_page(): void
    {
        $this->user();

        $this->get(route('home'))
            ->assertSuccessful()
            ->assertSeeLivewire('tasks.create');

        $this->get(route('sources'))
            ->assertSuccessful()
            ->assertSeeLivewire('tasks.create');
    }

}
