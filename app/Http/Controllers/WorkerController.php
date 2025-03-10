<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass as ResponseClass;
use App\Http\Requests\Worker\AssignRole;
use App\Http\Requests\Worker\Store as StoreWorker;
use App\Http\Requests\Worker\Update as UpdateWorker;
use App\Http\Resources\WorkerResource;
use App\Interfaces\WorkerRepositoryInterface;
use App\Models\Task;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class WorkerController extends Controller
{

    private WorkerRepositoryInterface $workerRepositoryInterface;

    public function __construct(WorkerRepositoryInterface $workerRepositoryInterface)
    {
        $this->workerRepositoryInterface = $workerRepositoryInterface;
    }
    /**
     * Отображаем листинг ресурса.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['name','email','status', 'created_at']);

        $sortField = $request->input('sort_field');
        $sortOrder = $request->input('sort_order', 'asc');

        $data = $this->workerRepositoryInterface->index($filters, $sortField, $sortOrder);

        return ResponseClass::sendResponse(WorkerResource::collection($data),'',200);
    }

    /**
     * Сохраняем вновь созданный ресурс в хранилище.
     */
    public function store(StoreWorker $request)
    {
        $details =[
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
        ];
        DB::beginTransaction();
        try{
             $worker = $this->workerRepositoryInterface->store($details);

             DB::commit();
             return ResponseClass::sendResponse(new WorkerResource($worker),'Сотрудник успешно добавлен',201);

        }catch(\Exception $ex){
            return ResponseClass::rollback($ex);
        }
    }

    /**
     * Отображаем указанный ресурс.
     */
    public function show($id)
    {
        $worker = $this->workerRepositoryInterface->getById($id);
        if (!$worker) {
            return ResponseClass::sendResponse('Сотрудник не найден','',404);
        }

        return ResponseClass::sendResponse(new WorkerResource($worker),'',200);
    }

    /**
     * Обновляем указанный ресурс в хранилище.
     */
    public function update(UpdateWorker $request, $id)
    {
        $worker = Worker::find($id);
        $updateDetails =[
            'name' => $request->name ?? $worker->name,
            'email' => $request->email ?? $worker->email,
            'status' => $request->status ?? $worker->status,
        ];
        DB::beginTransaction();
        try{
             $worker = $this->workerRepositoryInterface->update($updateDetails,$id);

             DB::commit();
             return ResponseClass::sendResponse('Данные сотрудника обновлены','',201);

        }catch(\Exception $ex){
            return ResponseClass::rollback($ex);
        }
    }

    /**
     * Удаляем указанный ресурс из хранилища.
     */
    public function destroy($id)
    {
         $this->workerRepositoryInterface->delete($id);

        return ResponseClass::sendResponse('Сотрудник успешно удалён','',200); //или 204
    }

     /**
     * Листинг ресурса для связанной модели
     */
    public function getWorkers($idTask)
    {
        if (!Task::find($idTask)) {
            return ResponseClass::sendResponse('Задача не найдена','',404);
        }

        $data = $this->workerRepositoryInterface->getWorkers($idTask);

        return ResponseClass::sendResponse(WorkerResource::collection($data),'Сотрудники, которым назначена задача id='.$idTask,200);

    }

    /**
     * Управление ролями
     *
     */
    public function assignRole(AssignRole $request, $workerId)
    {
        $role_id = $request->role_id;

        DB::beginTransaction();
        try{

            $worker = $this->workerRepositoryInterface->assignRole($role_id,$workerId);

             DB::commit();
             return ResponseClass::sendResponse(new WorkerResource($worker),'Роль успешно назначена сотруднику.',201);

        }catch(\Exception $ex){
            return ResponseClass::rollback($ex);
        }

    }

    public function removeRole($workerId, $roleId)
    {
        DB::beginTransaction();
        try{

            $worker = $this->workerRepositoryInterface->removeRole($workerId,$roleId);

             DB::commit();
             return ResponseClass::sendResponse(new WorkerResource($worker),'Роль успешно удалена у сотрудника.',201);

        }catch(\Exception $ex){
            return ResponseClass::rollback($ex);
        }
    }

}
