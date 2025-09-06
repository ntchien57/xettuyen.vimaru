<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComboOffset extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'combo_code','base_code','method','delta','order_no','active'
    ];

    protected $casts = [
        'delta'  => 'float',
        'active' => 'boolean',
    ];
}
