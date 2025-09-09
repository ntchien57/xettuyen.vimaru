<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Major extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'group_name',
        'exam_combos',
        'is_advanced',
        'is_optional',
        'taught_in_english',
        'order_no',
        'active',
        'note',
        'quota',
        'cutoff_score',
    ];

    protected $casts = [
        'exam_combos'        => 'array',
        'is_advanced'        => 'boolean',
        'is_optional'        => 'boolean',
        'taught_in_english'  => 'boolean',
        'active'             => 'boolean',
        'quota'             => 'integer',  // <— thêm
        'cutoff_score'      => 'float',    // <— thêm
    ];

    public function wishes()
    {
        return $this->hasMany(\App\Models\Wish::class, 'major_code', 'code');
    }
}
