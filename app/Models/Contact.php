<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company',
        'phone',
        'email',
        'user_id',  // Ensure user_id is fillable so it can be assigned
    ];
}
