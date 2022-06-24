@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">タスクの新規追加</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('task.update',["id" => $task_data->id]) }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">ユーザー名</label>

                                <div class="col-md-6">
                                    <label for="name" class="col-md-4 col-form-label">{{Auth::user()->name}}</label>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="title" class="col-md-4 col-form-label text-md-end">タイトル</label>

                                <div class="col-md-6">
                                    <input id="title" type="text"
                                           class="form-control @error('title') is-invalid @enderror" name="title"
                                           value="{{$task_data->title}}" required autocomplete="title" autofocus>

                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="body" class="col-md-4 col-form-label text-md-end">内容</label>
                                <div class="col-md-6">
                                    <textarea id="body" type="text" rows="10" cols="40"
                                              class="form-control" name="body"
                                              autocomplete="body" autofocus>{{ $task_data->body }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="status" class="col-md-4 col-form-label text-md-end p-1">ステータス</label>
                                <div class="col-md-6 d-flex"
                                     style="flex-wrap: nowrap; align-items: center;">
                                    <div class="form-check m-1">
                                        <input class="form-check-input" type="radio" value="0" name="status"
                                               id="flexRadioDefault1" checked>
                                        <label class="form-check-label" for="not_compatible">
                                            未対応
                                        </label>
                                    </div>
                                    <div class="form-check m-1">
                                        <input class="form-check-input " type="radio" value="1" name="status"
                                               id="flexRadioDefault2">
                                        <label class="form-check-label" for="complete">
                                            完了
                                        </label>
                                    </div>

                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="deadline" class="col-md-4 col-form-label text-md-end">期限</label>

                                <div class="col-md-6">
                                    <input type="date" class="form-control" name="deadline"
                                           value="{{$task_data->deadline}}"
                                           autocomplete="deadline" autofocus>
                                    @error('deadline')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="deadline" class="col-md-4 col-form-label text-md-end"></label>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary float-end">更新</button>
                                    <div class="col-md-9">
                                        <button type="button" id="delete_task" class="btn btn-danger float-end">削除
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form name="delete_form" method="POST" action="{{route("task.delete",["id" => $task_data->id])}}">
        @csrf
    </form>
    <script src="{{asset("js/task/delete.js")}}"></script>
@endsection
