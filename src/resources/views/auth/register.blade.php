@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<h2 class="register-header">会員登録</h2>

<form action="/register" class="register-form" method="POST">
@csrf
    <input type="text" class="register-form__column" name="name" placeholder="名前" value="{{ old('name') }}">
    <div class="form__error">
        @error('name')
            {{ $message }}
        @enderror
    </div>
    <input type="text" class="register-form__column" name="email" placeholder="メールアドレス" value="{{ old('email') }}">
    <div class="form__error">
        @error('email')
            {{ $message }}
        @enderror
    </div>
    <input type="password" class="register-form__column" name="password" placeholder="パスワード" value="{{ old('password') }}">
    <div class="form__error">
        @error('password')
            {{ $message }}
        @enderror
    </div>
    <input type="password" class="register-form__column" name="password_confirmation" placeholder="確認用パスワード" value="{{ old('password_confirmation') }}">
    <button class="register-form__button">会員登録</button>
</form>

<div class="login-recommend">
    <p class="login-recommend__text">アカウントをお持ちの方はこちらから</p>
    <div class="login-recommend__anchor">
        <a href="/login">ログイン</a>
    </div>
</div>
@endsection