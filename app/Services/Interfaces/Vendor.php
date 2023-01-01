<?php

namespace App\Services\Interfaces;

use Illuminate\Support\Collection;

interface Vendor
{
    /**
     * @return Collection
     */
    public function getNewTasks(): Collection;
}
