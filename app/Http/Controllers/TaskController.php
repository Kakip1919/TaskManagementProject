<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    public function index(Request $request)
    {
        if (!Auth::check()) return view("task.index");
        $task_data = Task::TaskIndex($request);
        $kind = $request->input("kind");
        return view("task.index", compact("task_data","kind"));
    }

    public function create()
    {
        return view("task.create");
    }

    public function store(Request $request)
    {
        Task::TaskStore($request);
        return redirect("/")->with("flash_message", "タスクが作成されました。");
    }

    public function edit($id)
    {
        $task_data = Task::where("id", $id)->first();
        return view("task.edit", compact("task_data"));
    }

    public function update($id, Request $request)
    {
        Task::TaskUpdate($id, $request);
        return redirect("/")->with("flash_message", "タスクを更新しました。");
    }

    public function delete($id)
    {
        Task::TaskDelete($id);
        return redirect("/")->with("flash_message", "タスクを削除しました。");
    }

}
