<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Work;
use App\Models\Breaking;
use Illuminate\Support\Facades\DB;

class AttendanceProcess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process attendance for the day';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // 仕事中の人を取得
        $during_users = Work::whereDate('date',now()->format('Y-m-d'))->whereNull('end_time')->with('breaking')->get();

        try{

            DB::transaction(function() use ($during_users){
                foreach($during_users as $during_user){
                    $user_id = $during_user->user_id;
                    // 本日の勤務終了処理
                    $during_user->update(['end_time' => now()->format("H:i:s")]);

                    // 翌日の勤務開始処理
                    $new_work = Work::create([
                        'user_id' => $user_id,
                        'date' => now()->addDay()->format('Y-m-d'),
                        'start_time' => '00:00:00',
                    ]);

                    // 休憩のリレーションがあるか判断
                    if($during_user->breaking){
                        $breaking_user = Breaking::whereNull('end_time')->first();

                        // 休憩中か判断
                        if($breaking_user){
                            // 本日の休憩終了処理
                            $breaking_user->update(['end_time' => now()->format("H:i:s")]);
                            // 翌日の休憩開始処理
                            Breaking::create([
                                'user_id' => $user_id,
                                'work_id' => $new_work->id, // 翌日の勤務レコードのIDを指定
                                'start_time' => '00:00:00',
                            ]);
                        }
                    }
                }
                DB::commit();
            });
            info('Inside transaction: Success');
        }catch(\Exception $e){
            DB::rollBack();
            info('Inside transaction: Error', ['error' => $e->getMessage()]);
        throw $e;
        }

        if($during_users->isEmpty()){

        }

        info('attendance:process command executed successfully');
    }
}
