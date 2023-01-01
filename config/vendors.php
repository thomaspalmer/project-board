<?php

use App\Enums\Vendors;

return [
    [
        'name' => 'GitHub',
        'src' => '/images/vendors/github.png',
        'value' => Vendors::GitHub,
    ],
    [
        'name' => 'Trello',
        'src' => '/images/vendors/trello.png',
        'value' => Vendors::Trello,
    ],
    [
        'name' => 'Active Collab',
        'src' => '/images/vendors/active-collab.png',
        'value' => Vendors::ActiveCollab,
        'interface' => \App\Services\Vendors\ActiveCollab::class,
    ],
];
