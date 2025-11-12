<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'grade',
        'location',
        'pin_code',
        'latitude',
        'longitude',
'subjects_of_interest',
        'date_of_birth',
        'city_id',
        'preferred_tutoring_modes',
        'onboarding_completed',
    ];

    protected $casts = [
'subjects_of_interest' => 'array',
        'preferred_tutoring_modes' => 'array',
        'date_of_birth' => 'date',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
