<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        if(!Auth::check()) return view("task.index");

        $user_id = Auth::user()->id;
        $task_response = Task::where("user_id", $user_id)->paginate(5);

        return view("task.index",compact("task_response"));
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

    public function edit()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }
}
