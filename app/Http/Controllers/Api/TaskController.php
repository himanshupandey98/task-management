<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskController extends Controller
{
    /**
     * Create a new task.
     */

    protected $taskRepository;

    private function validateData()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'priority' => 'required|in:Low,Medium,High',
            'due_date' => 'required|date|after_or_equal:today',
        ];
    }
    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Get all tasks with pagination.
     */
    public function index(Request $request)
    {
        try {

            $tasks = $this->taskRepository->getAllTasks($request->query->all());

            return response()->json($tasks, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve tasks',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            // Validate request data
            $validator = Validator::make($request->all(), $this->validateData());

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Create task
            $task = $this->taskRepository->createTask($validator->validated());


            return response()->json([
                'message' => 'Task created successfully',
                'task' => $task
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create task',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get a single task by ID.
     */
    public function show($id)
    {
        try {
            $task = $this->taskRepository->findTaskById($id);
            return response()->json($task);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Task not found'], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve task',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update a task.
     */
    public function update(Request $request, $id)
    {
        try {
            $task = Task::findOrFail($id);

            // Validate request data
            $validator = Validator::make($request->all(), $this->validateData());

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $task = $this->taskRepository->updateTask($id, $validator->validated());

            return response()->json([
                'message' => 'Task updated successfully',
                'task' => $task
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Task not found'], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update task',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a task.
     */
    public function destroy($id)
    {
        try {

            $this->taskRepository->deleteTask($id);
            return response()->json([], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Task not found'], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to delete task',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mark a task as completed.
     */
    public function markAsCompleted($id)
    {
        try {
            $task = $this->taskRepository->findTaskById($id);

            // Check if the task is already completed
            if ($task->status === 'Completed') {
                return response()->json(['message' => 'Task is already completed'], 400);
            }

            $task = $this->taskRepository->updateTask($task, ['status' => 'Completed']);

            return response()->json([
                'message' => 'Task marked as completed successfully',
                'task' => $task
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Task not found'], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to mark task as completed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
