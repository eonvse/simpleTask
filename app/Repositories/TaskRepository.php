<?php

namespace App\Repositories;

use App\Models\Task;
use App\Interfaces\TaskRepositoryInterface;

class TaskRepository implements TaskRepositoryInterface
{
    public function index(){
        return Task::with('workers')->get();
    }

    public function getById($id){
       return Task::with('workers')->find($id);
    }

    public function store(array $data){
       return Task::create($data);
    }

    public function update(array $data,$id){
        $task = Task::find($id);
        $task->update($data);
        return Task::with('workers')->find($id);
    }

    public function delete($id){
       Task::destroy($id);
    }

    public function assignWorker($worker_id, $id)
    {
        $task = Task::find($id);
        $task->workers()->syncWithoutDetaching([$worker_id]);

        return Task::with('workers')->find($id);
    }

    public function removeWorker($task_id,$worker_id)
    {
        $task = Task::find($task_id);
        $task->workers()->detach([$worker_id]);

        return Task::with('workers')->find($task_id);
    }

}
