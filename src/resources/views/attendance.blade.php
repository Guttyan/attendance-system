@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
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
    <div class="attendance-header">
        <form action="/attendance/before_day" method="GET">
            @csrf
            <input type="hidden" name="date" value="{{ $date }}">
            <div class="attendance-header__date-arrow--left">
                <button type="submit"><i class="fa-solid fa-chevron-left" style="color:#4169E1;"></i></button>
            </div>
        </form>
        <div><h3 class="attendance-header__date">{{ $date }}</h3></div>
        <form action="/attendance/next_day" method="GET">
            @csrf
            <input type="hidden" name="date" value="{{ $date }}">
            <div class="attendance-header__date-arrow--right">
                <button type="submit"><i class="fa-solid fa-chevron-right" style="color:#4169E1;"></i></button>
            </div>
        </form>
    </div>

    <table class="attendance-table">
        <tr class="attendance-table__row">
            <th class="attendance-table__row-header">名前</th>
            <th class="attendance-table__row-header">勤務開始</th>
            <th class="attendance-table__row-header">勤務終了</th>
            <th class="attendance-table__row-header">休憩時間</th>
            <th class="attendance-table__row-header">勤務時間</th>
        </tr>
        @foreach($works as $work)
        <tr class="attendance-table__row">
            <td class="attendance-table__row-inner">{{ $work->user->name }}</td>
            <td class="attendance-table__row-inner">{{ $work->start_time }}</td>
            <td class="attendance-table__row-inner">{{ $work->end_time }}</td>
            <td class="attendance-table__row-inner">
                <?php
                    $totalBreakingTime = $work->getTotalBreakingTime();
                    echo gmdate('H:i:s', $totalBreakingTime);
                ?>
            </td>
            <td class="attendance-table__row-inner">
                <?php
                    $totalBreakingTime = $work->getTotalBreakingTime();
                    $diff = (strtotime($work->end_time) - strtotime($work->start_time)) - $totalBreakingTime;
                    $work_time = gmdate('H:i:s', $diff);
                    echo $work_time;
                ?>
            </td>
        </tr>
        @endforeach
    </table>
        {{ $works->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4') }}
@endsection