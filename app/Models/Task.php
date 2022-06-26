<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * @method static TaskStore(Request $request)
 * @method static TaskUpdate($id, Request $request)
 * @method static TaskDelete($id)
 */
class Task extends Model
{
    use HasFactory;

    protected array $fillable = [
        "name",
        'title',
        'body',
        'status',
        'deadline',
    ];
    protected string $table = "tm_task";


    public function scopeTaskIndex($query, Request $request)
    {
        $search_keyword = $request->input("q");
        $kind = $request->input("kind");
   	$user_id = Auth::user()->id;
        $task_query = self::query();

        if ($kind === "deadline") {
            return Task::where("user_id", $user_id)->where("deadline", "<", date("Y-m-d"))->paginate(5);
        } elseif ($kind === "complete") {
            return Task::where("user_id", $user_id)->paginate(5);
        } else {
            if ($search_keyword !== null) {
                return self::where("user_id",$user_id)->where("status", 0)->where(function ($query) use ($search_keyword) {
    		    $query->orWhere("name", "like", "%" . "$search_keyword" . "%")->orWhere("title", "like", "%" . "$search_keyword" . "%")->orWhere("body", "like", "%" . "$search_keyword" . "%");
		})->select("id", "title", "deadline")->paginate(5);
	        }
         
            return Task::where("user_id", $user_id)->where("status", 0)->select("id", "title", "deadline")->paginate(5);
        }
    }


    public function scopeTaskStore($query, Request $request)
    {
        $request->validate([
            'title' => 'required|max:64',
            'body' => 'nullable',
        ]);

        //検索の冗長化のため追加
        $name = Auth::user()->name;
        $user_id = Auth::user()->id;
        $title = $request->input("title");
        $body = $request->input("body");
        $deadline = $request->input("deadline");


        DB::beginTransaction();
        try {
            self::insert(["name" => $name, "user_id" => $user_id, "title" => $title, "body" => $body, "deadline" => $deadline]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
    }


    public function scopeTaskUpdate($query, $id, Request $request)
    {
        $request->validate([
            'title' => 'required|max:64',
            'body' => 'nullable',
        ]);
        $title = $request->input("title");
        $status = $request->input("status");
        $body = $request->input("body");
        $deadline = $request->input("deadline");


        DB::beginTransaction();
        try {
            self::find($id)->update(["title" => $title, "body" => $body, "status" => $status, "deadline" => $deadline]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
    }


    public function scopeTaskDelete($query, $id)
    {
        self::find($id)->delete();
    }

}
