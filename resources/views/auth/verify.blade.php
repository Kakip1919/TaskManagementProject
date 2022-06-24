@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">メールアドレス認証はお済みですか？</div>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                本登録用メールを再送信しました！
                            </div>
                        @endif

                        このページを閲覧するには、メールアドレスによる本登録が必要です。
                        もし認証用のメールを受け取っていない場合、
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">こちらのリンク</button>をクリックして、本登録用メールを受け取ってください。
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
