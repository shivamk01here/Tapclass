<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationIssue extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'role',
        'message',
        'payload',
        'status',
    ];

    protected $casts = [
        'payload' => 'array',
    ];
}
