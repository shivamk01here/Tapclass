<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function tutorProfiles()
    {
        return $this->belongsToMany(TutorProfile::class, 'tutor_subjects', 'subject_id', 'tutor_profile_id')
                    ->withPivot('online_rate', 'offline_rate', 'is_online_available', 'is_offline_available')
                    ->withTimestamps();
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
