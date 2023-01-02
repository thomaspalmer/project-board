<?php

namespace App\Services\Vendors;

use App\Enums\Priorities;
use ActiveCollab\SDK\{Authenticator\Cloud, Client, Exceptions\Authentication, Token};
use App\Models\Source;
use App\Services\Interfaces\Vendor;
use Carbon\Carbon;
use Illuminate\Support\{Collection, Facades\Log};
use Exception;

class ActiveCollab extends Base implements Vendor
{
    /**
     * @var Cloud
     */
    private Cloud $authenticator;

    /**
     * @var Token
     */
    private Token $token;

    /**
     * @var Client
     */
    private Client $client;

    /**
     * @var ?int
     */
    private ?int $userId = null;

    /**
     * @param Source $source
     * @throws Authentication
     */
    public function __construct(Source $source)
    {
        parent::__construct($source);

        $this->authenticator = new Cloud(
            $this->source->credentials['company_name'],
            config('app.name'),
            $this->source->credentials['email'],
            $this->source->credentials['password'],
        );

        $this->token = $this->authenticator->issueToken((int) $this->source->credentials['account_number']);

        $this->client = new Client($this->token);
    }

    /**
     * @return Collection
     * @throws Exception
     */
    public function getNewTasks(): Collection
    {
        try {
            return collect(json_decode($this->client->get('users/' . $this->getUserId() . '/tasks')->getBody())->tasks)
                ->map(fn ($task) => [
                    'external_id' => $task->id,
                    'title' => $task->name,
                    'description' => $task->body,
                    'priority' => $task->is_important ? Priorities::High : Priorities::Medium,
                    'due_at' => Carbon::createFromTimestamp($task->due_on),
                    'link' => $this->token->getUrl() . $task->url_path,
                ]);
        } catch (Exception $exception) {
            Log::error('Error fetching user tasks from active collab: ' . $exception->getMessage());

            throw $exception;
        }
    }

    /**
     * @return int
     * @throws Exception
     */
    private function getUserId(): int
    {
        if (!$this->userId) {
            try {
                $this->userId = json_decode($this->client->get('/user-session')->getBody())->logged_user_id;
            } catch (Exception $exception) {
                Log::error('Error fetching users id from active collab: ' . $exception->getMessage());

                throw $exception;
            }
        }

        return $this->userId;
    }
}
