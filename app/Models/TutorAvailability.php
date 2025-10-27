<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorAvailability extends Model
{
    use HasFactory;

    protected $fillable = [
        'tutor_profile_id',
        'day_of_week',
        'start_time',
        'end_time',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
    ];

    public function tutorProfile()
    {
        return $this->belongsTo(TutorProfile::class);
    }
}
