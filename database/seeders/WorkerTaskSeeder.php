<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Worker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkerTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создаём 20 работников
        $workers = Worker::factory()->count(20)->create();
        // Создаём 200 задач
        $tasks = Task::factory()->count(200)->create();

        // Связываем работников и задачи
        $tasks->each(function ($task) use ($workers) {
            $task->workers()->attach(
                $workers->random(rand(1, 5))->pluck('id')->toArray()
            );
        });

    }
}
