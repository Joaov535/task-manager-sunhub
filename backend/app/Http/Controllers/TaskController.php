<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskController extends Controller
{
    public function load(Request $request)
    {
        $user = $request->user();

        $tasks = [];
        $tasks = Task::getAllTasks($user->id);

        return response()->json($tasks, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string|in:pending,underway,finish',
        ]);

        $user = $request->user();
        $task = Task::createTask($request->all(), $user->id);

        return response()->json($task, 201);
    }

    public function update(Request $request, $taskID)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string|in:pending,underway,finish',
        ]);

        $user = $request->user();

        try {
            $task = Task::findOrFail($taskID);
        } catch (ModelNotFoundException) {
            return response()->json([
                'error' => 'ID de tarefa não encontrado',
                'message' => 'O id enviado não corresponde com nenhuma tarefa salva'
            ], 404);
        }

        if ($task->user_id != $user->id) {
            return response()->json([
                'error' => 'Acesso negado',
                'message' => 'Você não tem permissão para gerenciar essa tarefa'
            ], 403);
        }

        $task->title = $request->title;
        $task->description = $request->description;
        $task->updated_at = date('Y-m-d H:i:s');
        $task->status = $request->status;
        $task->save();

        return response()->json($task, 200);
    }

    public function delete(Request $request, $taskID)
    {
        $user = $request->user();

        try {
            $task = Task::findOrFail($taskID);

            if ($task->user_id != $user->id) {
                throw new \Exception;
            }
        } catch (ModelNotFoundException) {
            return response()->json([
                'error' => 'ID de tarefa não encontrado',
                'message' => 'O id enviado não corresponde com nenhuma tarefa salva'
            ], 404);
        }

        if ($task->user_id != $user->id) {
            return response()->json([
                'error' => 'Acesso negado',
                'message' => 'Você não tem permissão para gerenciar essa tarefa'
            ], 403);
        }

        $task->delete();

        return response()->json([
            'message' => 'Tarefa excluída com sucesso.'
        ], 200);
    }
}
