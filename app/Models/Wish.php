<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wish extends Model
{
    protected $fillable = [
        'user_id','major_code','order_no','exam_id',
        'exam_combo','method','raw_score','converted_score',
        'status','note',
    ];

    protected $casts = [
        'raw_score'       => 'float',
        'converted_score' => 'float',
        'order_no'        => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    // majors.code → wish.major_code
    public function major()
    {
        return $this->belongsTo(\App\Models\Major::class, 'major_code', 'code');
    }
}
