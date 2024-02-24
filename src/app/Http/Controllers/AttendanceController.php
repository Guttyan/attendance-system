<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Work;
use App\Models\Breaking;
use Illuminate\Pagination\Paginator;

use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    // 打刻ページ表示
    public function index(){
        $user = Auth::user();
        $user_id = Auth::id();
        $date = Carbon::now()->format('Y-m-d');
        $nowWork = Work::where('user_id',$user_id)->where('date', $date)->whereNull('end_time')->latest()->first();
        $nowBreaking = Breaking::where('user_id', $user_id)->whereNull('end_time')->latest()->first();
        return view('stamp', [
            'user' => $user,
            'nowWork' => $nowWork,
            'nowBreaking' => $nowBreaking,
        ]);
    }

    // 勤務開始処理
    public function work_begin(){
        $user_id = Auth::id();
        $now = Carbon::now();
        $date = $now->format('Y-m-d');
        $start_time = $now->format('H:i:s');
        Work::create([
            'user_id' => $user_id,
            'date' => $date,
            'start_time' => $start_time,
        ]);
        return redirect('/');
    }

    // 勤務終了処理
    public function work_finish(){
        $user_id = Auth::id();
        $now = Carbon::now();
        $date = $now->format('Y-m-d');
        $end_time = $now->format('H:i:s');
        $work = Work::where('user_id',$user_id)->where('date',$date)->latest()->first();
        $work->update(["end_time" => $end_time]);
        return redirect('/');
    }

    // 休憩開始処理
    public function breaking_begin(){
        $user_id = Auth::id();
        $date = Carbon::now()->format('Y-m-d');
        $now_work = Work::where('user_id',$user_id)->where('date', $date)->latest()->first();
        $work_id = $now_work['id'];
        $start_time = Carbon::now()->format('H:i:s');
        Breaking::create([
            'user_id' => $user_id,
            'work_id' => $work_id,
            'start_time' => $start_time,
        ]);
        return redirect('/');
    }

    // 休憩終了処理
    public function breaking_finish(){
        $user_id = Auth::id();
        $end_time = Carbon::now()->format('H:i:s');
        $now_breaking = Breaking::where('user_id',$user_id)->latest()->first();
        $now_breaking->update(["end_time" => $end_time]);
        return redirect('/');
    }

    // 日付別勤怠ページ表示（当日）
    public function attendance(){
        $date = Carbon::now()->format('Y-m-d');
        $works = Work::where('date',$date)->with(['user','breaking'])->paginate(5);
        return view('attendance',compact('date','works'));
    }

    // 翌日の勤怠ページ表示
    public function next_day(Request $request){
        $old_date = strtotime($request->date);
        $day = new Carbon(date('Y-m-d',$old_date));
        $new_date = $day->addDay()->format('Y-m-d');
        $works = Work::where('date',$new_date)->with(['user','breaking'])->paginate(5);
        return view('attendance', ['date' => $new_date, 'works' => $works]);
    }

    // 前日の勤怠ページ表示
    public function before_day(Request $request){
        $old_date = strtotime($request->date);
        $day = new Carbon(date('Y-m-d',$old_date));
        $new_date = $day->subDay()->format('Y-m-d');
        $works = Work::where('date',$new_date)->with(['user','breaking'])->paginate(5);
        return view('attendance', ['date' => $new_date, 'works' => $works]);
    }

    // ユーザー一覧表示
    public function users_list(){
        $users = User::paginate(16);
        return view('users_list', compact('users'));
    }

    // ユーザー別勤怠ページ表示
    public function user_record(Request $request){
        $user_id = $request->user_id;
        $user = User::find($user_id);
        $works = Work::where('user_id', $user_id)->with('breaking')->paginate(5);
        return view('user_record', compact('user', 'works'));
    }
}
