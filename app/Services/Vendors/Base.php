<?php

namespace App\Services\Vendors;

use App\Models\Source;

class Base
{
    public function __construct(
        protected readonly Source $source
    ) {}
}
