<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\TaskController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/workers',WorkerController::class);

Route::post('/workers/{worker}/assign-role', [WorkerController::class, 'assignRole']);
Route::delete('/workers/{worker}/remove-role/{roleId}', [WorkerController::class, 'removeRole']);

Route::apiResource('/tasks',TaskController::class);
Route::get('/tasks-grouped-by-status', [TaskController::class, 'indexGroupedByStatus']);

Route::post('/tasks', [TaskController::class, 'store'])
    ->middleware('throttle:create-tasks');

// Управление назначенными сотрудниками задания
Route::prefix('tasks/{task}')->group(function () {
    Route::get('workers', [WorkerController::class, 'getWorkers']); // Получить назначенных сотрудников
    Route::post('workers', [TaskController::class, 'assignWorker']); // Назначить задачу сотруднику
    Route::delete('workers/{worker}', [TaskController::class, 'removeWorker']); // Удалить задачу у сотрудника*/
});


