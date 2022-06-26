@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">タスクの新規追加</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('task.store') }}">
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
                                           value="{{ old('title') }}" autocomplete="title" autofocus>

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
                                              autocomplete="body" autofocus>{{ old('body') }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="deadline" class="col-md-4 col-form-label text-md-end">期限</label>

                                <div class="col-md-6">
                                    <input type="date" class="form-control @error('deadline') is-invalid @enderror" name="deadline"
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
                                    <input type="submit" class="btn btn-primary float-end">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
