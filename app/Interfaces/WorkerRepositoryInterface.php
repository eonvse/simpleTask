<?php

namespace App\Interfaces;

interface WorkerRepositoryInterface
{
    public function index();
    public function getById($id);
    public function store(array $data);
    public function update(array $data,$id);
    public function delete($id);
    public function getWorkers($id);
    public function assignRole($role_id, $id);
    public function removeRole($worker_id, $role_id);

}
