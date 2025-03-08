<?php

namespace App\Repositories;

use App\Interfaces\WorkerRepositoryInterface;
use App\Models\Task;
use App\Models\Worker;

class WorkerRepository implements WorkerRepositoryInterface
{
    public function index(){
        return Worker::all();
    }

    public function getById($id){
       return Worker::find($id);
    }

    public function store(array $data){
       return Worker::create($data);
    }

    public function update(array $data,$id){
       return Worker::whereId($id)->update($data);
    }

    public function delete($id){
       Worker::destroy($id);
    }

    public function getWorkers($idTask)
    {
        return Task::find($idTask)->workers()->get();
    }

}
