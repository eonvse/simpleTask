<?php

namespace App\Observers;

use App\Events\TaskStatusChanged;
use App\Models\Task;

class TaskObserver
{
    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        // Проверяем, изменился ли статус задачи
        if ($task->isDirty('status')) {
            $oldStatus = $task->getOriginal('status');
            $newStatus = $task->status;

            // Вызываем событие
            TaskStatusChanged::dispatch($task, $oldStatus, $newStatus);

        }
    }

}
