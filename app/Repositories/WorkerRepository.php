<?php

namespace App\Repositories;

use App\Interfaces\WorkerRepositoryInterface;
use App\Models\Role;
use App\Models\Task;
use App\Models\Worker;

class WorkerRepository implements WorkerRepositoryInterface
{
    public function index(){
        return Worker::all();
    }

    public function getById($id){
       return Worker::with('roles')->find($id);
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

    public function assignRole($role_id, $id)
    {
        $worker = Worker::find($id);
        $role = Role::find($role_id);

        $worker->assignRole($role);
        return Worker::with('roles')->find($id);

    }

    public function removeRole($worker_id, $role_id)
    {
        $worker = Worker::find($worker_id);
        $role = Role::findOrFail($role_id);

        $worker->removeRole($role);

        return Worker::with('roles')->find($worker_id);

    }


}
