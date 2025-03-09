<?php

namespace App\Interfaces;

interface TaskRepositoryInterface
{
    public function index($filters = [], $sortField = null, $sortOrder = 'asc');
    public function getById($id);
    public function store(array $data);
    public function update(array $data,$id);
    public function delete($id);
    public function assignWorker($worker_id, $id);
    public function removeWorker($task_id, $worker_id);

}
