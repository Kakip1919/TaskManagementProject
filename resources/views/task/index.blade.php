@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if(Auth::check())
                    <div id="search_group">
                    </div>
                    <div class="card">
                        <div class="col-md-12 mb-3">
                            <span><input type="checkbox">期限超過のみ</span>
                            <span><input type="checkbox">完了済みを表示</span>

                            <a href="{{route("task.create")}}">
                                <button type="button" class="btn btn-primary float-end">+ タスクの追加</button>
                            </a>
                        </div>
                        <table class="table table-hover table-secondary">
                            <thead>
                            <tr>
                                <th scope="col">ユーザー名</th>
                                <th scope="col">タスク</th>
                                <th scope="col">期日</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($task_response as $task_data)
                                <tr>
                                    <td>{{Auth::user()->name}}</td>
                                    <td>{{$task_data->title}}</td>
                                    <td>{{$task_data->deadline}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="card">
                        <div class="card-header border border-danger"> タスクを表示するには、ログインしてください。</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
