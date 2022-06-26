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
        'title',
        'body',
        'status',
        'deadline',
    ];
    protected string $table = "tm_task";


    public function scopeTaskStore($query, Request $request)
    {
        $request->validate([
            'title' => 'required|max:64',
            'body' => 'nullable',
        ]);
        $user_id = Auth::user()->id;
        $title = $request->input("title");
        $body = $request->input("body");
        $deadline = $request->input("deadline");


        DB::beginTransaction();
        try {
            self::insert(["user_id" => $user_id, "title" => $title, "body" => $body, "deadline" => $deadline]);
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
