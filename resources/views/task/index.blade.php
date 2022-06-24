@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- フラッシュメッセージ -->
                @if (session('flash_message'))
                    <div class="flash_message alert alert-success">
                        {{ session('flash_message') }}
                    </div>
                @endif
                @if(Auth::check())
                    <form method="GET" action="{{route("task.index")}}">
                        <div class="input-group">
                            <div class="col-md-5 mb-5">
                                <input type="text" class="form-control mr-1" name="q">
                            </div>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary" style="margin-left: 10px">検索する</button>
                            </span>
                        </div>
                    </form>
                    <div class="col-md-12 mb-3">
                        <span class="p-1"><input id="deadline" class="form-check-inline" type="checkbox"@if($kind === "deadline") checked @endif>期限超過のみ</span>
                        <span class="p-1"><input id="complete" class="form-check-inline" type="checkbox"@if($kind === "complete") checked @endif>完了済を表示</span>

                        <a href="{{route("task.create")}}">
                            <button type="button" class="btn btn-primary float-end">+ タスクの追加</button>
                        </a>
                        <table class="table table-hover table-secondary">
                            <thead>
                            <tr>
                                <th scope="col">ユーザー名</th>
                                <th scope="col">タスク</th>
                                <th scope="col">期限</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($task_data as $data)
                                <tr>
                                    <td><a href="{{route("task.edit",["id" => $data->id])}}">{{Auth::user()->name}}</a></td>
                                    <td><a href="{{route("task.edit",["id" => $data->id])}}">{{$data->title}}</a></td>
                                    <td><a href="{{route("task.edit",["id" => $data->id])}}">{{$data->deadline}}</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{$task_data->appends(request()->query())->links()}}
                    </div>
                @else
                    <div class="card">
                        <div class="card-header alert alert-danger"> タスクを表示するには、ログインしてください。</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script src="{{asset("js/task/switch.js")}}"></script>
@endsection
