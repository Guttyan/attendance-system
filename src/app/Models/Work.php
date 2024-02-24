<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'start_time',
        'end_time'
    ];

    public function breaking(){
        return $this->hasMany(Breaking::class);
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function getTotalBreakingTime(){
        $totalBreakingTime = 0;
        foreach ($this->breaking as $break) {
            if ($break->end_time) {
                $diff = strtotime($break->end_time) - strtotime($break->start_time);
                $totalBreakingTime += $diff;
            }
        }
        return $totalBreakingTime;
    }
}
