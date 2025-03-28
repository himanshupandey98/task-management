<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;

class TaskRepository implements TaskRepositoryInterface
{
    public function getAllTasks($filters)
    {
        $query = Task::query();

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (!empty($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }
        if (!empty($filters['title'])) {
            $titles = explode(' ', $filters['title']);
            foreach ($titles as $word) {
                $query->where('title', 'like', "%$word%");
            }
        }

        return $query->paginate(10);
    }

    public function findTaskById($id)
    {
        return Task::findOrFail($id);
    }

    public function createTask(array $data)
    {
        return Task::create($data);
    }

    public function updateTask($task, array $data)
    {
        if (!$task instanceof Task) {
            $task = Task::findOrFail($task); // Fetch if only ID is passed
        }

        $task->update($data);
        return $task;
    }

    public function deleteTask($id)
    {
        return Task::destroy($id);
    }
}
