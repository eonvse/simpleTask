<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use App\Http\Requests\Worker\Store as StoreWorker;
use App\Http\Requests\Worker\Update as UpdateWorker;
use App\Interfaces\WorkerRepositoryInterface;
use App\Classes\ApiResponseClass as ResponseClass;
use App\Http\Resources\WorkerResource;
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
    public function index()
    {
        $data = $this->workerRepositoryInterface->index();

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
}
