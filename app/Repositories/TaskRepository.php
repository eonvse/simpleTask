<?php

namespace App\Repositories;

use App\Models\Task;
use App\Interfaces\TaskRepositoryInterface;

class TaskRepository implements TaskRepositoryInterface
{
    public function index(){
        return Task::all();
    }

    public function getById($id){
       return Task::find($id);
    }

    public function store(array $data){
       return Task::create($data);
    }

    public function update(array $data,$id){
       return Task::whereId($id)->update($data);
    }

    public function delete($id){
       Task::destroy($id);
    }

}
