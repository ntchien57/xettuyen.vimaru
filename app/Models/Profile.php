<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'full_name','dob','gender','ethnicity',
        'cccd_number','birth_place','email','phone',
        'cccd_front_path','cccd_back_path','address',
        'priority_object','priority_area','graduation_year',
        'contact_name','contact_relation','contact_phone','contact_email',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
