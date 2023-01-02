<?php

namespace App\Console\Commands;

use App\Models\Source;
use App\Models\Task;
use Exception;
use Illuminate\Console\Command;

class TasksSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): void
    {
        Source::where('active', true)
            ->get()
            ->filter(fn ($source) => isset($source->vendor_info['interface']))
            ->each(function ($source) {
                try {
                    // Get a list of new tasks
                    $class = new $source->vendor_info['interface']($source);
                    $newTasks = $class->getNewTasks();

                    $newTasks->each(function ($task) use ($source) {
                        Task::updateOrCreate([
                            'user_id' => $source->user_id,
                            'source_id' => $source->id,
                            'external_id' => $task['external_id'],
                        ], $task);
                    });

                    // If a task wasn't update above, then we can assume it is completed, or no longer assigned
                    // to the user. Update to completed by setting the completed_at.
                    Task::where([
                        'user_id' => $source->user_id,
                        'source_id' => $source->id,
                    ])
                        ->whereNotIn('external_id', $newTasks->pluck('external_id'))
                        ->whereNull('completed_at')
                        ->update([
                            'completed_at' => now(),
                        ]);
                } catch (Exception $exception) {
                    $source->update([
                        'error' => $exception->getMessage(),
                    ]);

                    dd($exception->getMessage());
                }
            });
    }
}
