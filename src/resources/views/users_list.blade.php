@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/users_list.css') }}">
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
    <h2 class="users-header">ユーザー一覧</h2>

    <div class="users__list">
        @foreach($users->chunk(16) as $chunk)
        <div class="users-column">
            <table class="users-table users-table__left">
                @foreach($chunk->take(8) as $user)
                <tr class="users-table__row">
                    <td class="users-table__name">{{ $user['name'] }}</td>
                    <td class="users-table__detail-button">
                        <form action="/users_list/user_record" class="users-detail__form" method="GET">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user['id'] }}">
                            <button>勤怠履歴</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        <div class="users-column">
            <table class="users-table users-table__right">
                @foreach($chunk->slice(8)->take(8) as $user)
                <tr class="users-table__row">
                    <td class="users-table__name">{{ $user['name'] }}</td>
                    <td class="users-table__detail-button">
                        <form action="/users_list/user_record" class="users-detail__form" method="GET">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user['id'] }}">
                            <button type="submit">勤怠履歴</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        @endforeach
    </div>
        {{ $users->links('vendor.pagination.bootstrap-4') }}

@endsection