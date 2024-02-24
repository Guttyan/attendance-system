@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/stamp.css') }}">
@endsection

@section('nav')
<ul class="header__nav">
    <li class="header__nav-list"><a href="/">ホーム</a></li>
    <li class="header__nav-list"><a href="/attendance">日付一覧</a></li>
    <li class="header__nav-list"><a href="/users_list">ユーザー一覧</a></li>
    <li class="header__nav-list">
        <form action="/logout" method="POST">
        @csrf
            <button type="submit" class="logout__button">ログアウト</button>
        </form>
    </li>
</ul>
@endsection



@section('content')
    <h2 class="stamp-header">{{ $user['name'] }}さんお疲れ様です！</h2>

    <div class="stamps">
        <form action="/work_begin" class="work-begin stamp" method="POST">
            @csrf
            <button class="work-begin__button stamp__button" type="submit" @if($nowWork) disabled @endif>勤務開始</button>
        </form>

        <form action="/work_finish" class="work-finish stamp" method="POST">
            @csrf
            <button class="work-finish__button stamp__button" type="submit"  @if(!$nowWork || ($nowWork && $nowBreaking)) disabled @endif>勤務終了</button>
        </form>

        <form action="/breaking_begin"  class="breaking-begin stamp" method="POST">
            @csrf
            <button class="breaking-begin__button stamp__button" type="submit"  @if((!$nowWork || $nowBreaking)) disabled @endif>休憩開始</button>
        </form>

        <form action="/breaking_finish" class="breaking-finish stamp" method="POST">
            @csrf
            <button class="breaking-button stamp__button" type="submit" @if(!$nowWork || ($nowWork && !$nowBreaking)) disabled @endif>休憩終了</button>
        </form>
    </div>
@endsection