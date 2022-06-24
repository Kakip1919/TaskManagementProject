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
 */
class Task extends Model
{
    use HasFactory;

    protected $table = "tm_task";


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
            dd($e);
        }
    }
}
