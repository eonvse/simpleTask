<?php

namespace App\Listeners;

use App\Events\TaskStatusChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendTaskStatusNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TaskStatusChanged $event): void
    {
        $task = $event->task;
        $newStatus = $event->newStatus;

        // Отправляем оповещение только для статусов "В работе" и "Выполнена"
        if (in_array($newStatus, ['В работе', 'Выполнена'])) {
            $workers = $task->workers;

            foreach ($workers as $worker) {
                $message = "Задача #{$task->id}, была переведена в статус {$newStatus}.";
                Log::info("Оповещение для сотрудника {$worker->id}: {$message}");
            }
        }
    }
}
