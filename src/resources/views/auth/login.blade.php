@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<h2 class="login-header">ログイン</h2>

<form action="/login" class="login-form" method="POST">
@csrf
    <input type="text" class="login-form__column" name="email" placeholder="メールアドレス" value="{{ old('email') }}">
    <div class="form__error">
        @error('email')
        {{ $message }}
        @enderror
    </div>
    <input type="password" class="login-form__column" name="password" placeholder="パスワード" value="{{ old('password') }}">
    <div class="form__error">
        @error('password')
        {{ $message }}
        @enderror
    </div>
    <button class="login-form__button">ログイン</button>
</form>

<div class="register-recommend">
    <p class="register-recommend__text">アカウントをお持ちの方はこちらから</p>
    <div class="register-recommend__anchor">
        <a href="/register">会員登録</a>
    </div>
</div>

@endsection