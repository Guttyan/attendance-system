<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model\Work;

class Breaking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'work_id',
        'start_time',
        'end_time'
    ];

    public function work(){
        return $this->belongsTo(Work::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

}
