<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * @return string
     */
    public function index() {
        return Task::all()->toJson();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $task = new Task();
        $task->title = $request->input('title');
        $task->completed = false;
        $task->save();

        return response()->json(['status' => 'success']);
    }

    /**
     * @param Task $task
     * @return Task
     */
    public function show(Task $task) {
        return $task;
    }

    /**
     * @param Request $request
     * @param Task $task
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, Task $task) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|alpha_dash|max:255',
            'completed' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response([
                'errorMessage' => 'Invalid input',
                'errors' => $validator->errors()->toArray()
            ], 400);
        }

        $task->title = $request->input('title');
        $task->completed = $request->input('completed');
        $task->save();

        return response()->json(['status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $task
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Task $task) {
        $task->delete();
        return response()->json(['status' => 'success']);
    }
}
