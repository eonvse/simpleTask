<?php

namespace App\Jobs;

use App\Models\Task;
use App\Models\Worker;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AssignTasksToWorkers implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        // Находим все неназначенные задачи
        $unassignedTasks = Task::doesntHave('workers')->get();

        // Находим всех активных сотрудников (не в отпуске)
        $activeWorkers = Worker::where('status', '!=', 'В отпуске')->get();

        if ($activeWorkers->isEmpty()) {
            // Если нет активных сотрудников, логируем ошибку
            Log::warning('Нет активных сотрудников для назначения задач.');
            return;
        }

        // Распределяем задачи между активными сотрудниками
        foreach ($unassignedTasks as $task) {
            $randomWorker = $activeWorkers->random(); // Случайный сотрудник
            $task->workers()->attach($randomWorker->id);

            Log::info("Задача {$task->id} назначена на сотрудника {$randomWorker->id}.");
        }
    }
}
