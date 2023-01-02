<?php

namespace App\Services\Vendors;

use App\Enums\DescriptionTypes;
use App\Enums\Priorities;
use App\Models\Source;
use App\Services\Interfaces\Vendor;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use GrahamCampbell\GitHub\Facades\GitHub as GitHubConnection;
use GitHub\Client;
use Illuminate\Support\Facades\Log;
use Exception;

class GitHub extends Base implements Vendor
{
    /**
     * @var Client
     */
    protected Client $client;

    /**
     * @param Source $source
     */
    public function __construct(Source $source)
    {
        parent::__construct($source);

        $this->client = GitHubConnection::getFactory()->make([
            'token'  => $this->source->credentials['personal_access_token'],
            'method' => 'token',
        ]);
    }

    /**
     * @return Collection
     * @throws Exception
     */
    public function getNewTasks(): Collection
    {
        try {
            return collect($this->client->me()->issues([
                'per_page' => 100

            ], false))
                ->map(fn ($task) => [
                    'external_id' => $task['id'],
                    'title' => $task['title'],
                    'description' => $task['body'],
                    'description_type' => DescriptionTypes::Markdown,
                    'priority' => Priorities::Medium,
                    'due_at' => Carbon::parse($task['created_at']),
                    'link' => $task['repository']['html_url'] . '/issues/' . $task['number'],
                ]);
        } catch (Exception $exception) {
            Log::error('Error fetching user tasks from GitHub: ' . $exception->getMessage());

            throw $exception;
        }
    }
}
