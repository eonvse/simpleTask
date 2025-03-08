<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass as ResponseClass;
use App\Http\Requests\Task\AssignWorker;
use App\Http\Requests\Task\RemoveWorker;
use App\Http\Requests\Task\Store as StoreTask;
use App\Http\Requests\Task\Update as UpdateTask;
use App\Http\Resources\TaskResource;
use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    private TaskRepositoryInterface $taskRepositoryInterface;

    public function __construct(TaskRepositoryInterface $taskRepositoryInterface)
    {
        $this->taskRepositoryInterface = $taskRepositoryInterface;
    }
    /**
     * Отображаем листинг ресурса.
     */
    public function index()
    {
        $data = $this->taskRepositoryInterface->index();

        return ResponseClass::sendResponse(TaskResource::collection($data),'',200);
    }

    /**
     * Сохраняем вновь созданный ресурс в хранилище.
     */
    public function store(StoreTask $request)
    {
        $details =[
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
        ];
        DB::beginTransaction();
        try{
             $task = $this->taskRepositoryInterface->store($details);

             DB::commit();
             return ResponseClass::sendResponse(new TaskResource($task),'Задача успешно добавлена',201);

        }catch(\Exception $ex){
            return ResponseClass::rollback($ex);
        }
    }

    /**
     * Отображаем указанный ресурс.
     */
    public function show($id)
    {
        $task = $this->taskRepositoryInterface->getById($id);
        if (!$task) {
            return ResponseClass::sendResponse('Задача не найдена','',404);
        }

        return ResponseClass::sendResponse(new TaskResource($task),'',200);
    }

    /**
     * Обновляем указанный ресурс в хранилище.
     */
    public function update(UpdateTask $request, $id)
    {
        $task = Task::find($id);
        $updateDetails =[
            'name' => $request->name ?? $task->name,
            'description' => $request->description ?? $task->description,
            'status' => $request->status ?? $task->status,
        ];
        DB::beginTransaction();
        try{
             $task = $this->taskRepositoryInterface->update($updateDetails,$id);

             DB::commit();
             return ResponseClass::sendResponse('Задача обновлена','',201);

        }catch(\Exception $ex){
            return ResponseClass::rollback($ex);
        }
    }

    /**
     * Удаляем указанный ресурс из хранилища.
     */
    public function destroy($id)
    {
         $this->taskRepositoryInterface->delete($id);

        return ResponseClass::sendResponse('Задача удалёна','',200); //или 204
    }

    /**
     * Назначаем сотрудника задаче.
     */
    public function assignWorker(AssignWorker $request, $id)
    {
        $worker_id = $request->worker_id;

        DB::beginTransaction();
        try{

            $task = $this->taskRepositoryInterface->assignWorker($worker_id,$id);

             DB::commit();
             return ResponseClass::sendResponse(new TaskResource($task),'Сотрудник id='.$worker_id." назначен на выполнение задачи",201);

        }catch(\Exception $ex){
            return ResponseClass::rollback($ex);
        }
    }

    /**
     * Убираем сотрудника с задачи.
     */
    public function removeWorker($task_id, $worker_id)
    {
        DB::beginTransaction();
        try{

            $task = $this->taskRepositoryInterface->removeWorker($task_id,$worker_id);

             DB::commit();
             return ResponseClass::sendResponse(new TaskResource($task),'Сотрудник id='.$worker_id." удалён с выполнения задачи",201);

        }catch(\Exception $ex){
            return ResponseClass::rollback($ex);
        }
    }

}
