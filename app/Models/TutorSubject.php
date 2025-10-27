<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorSubject extends Model
{
    use HasFactory;

    protected $fillable = [
        'tutor_profile_id',
        'subject_id',
        'online_rate',
        'offline_rate',
        'is_online_available',
        'is_offline_available',
    ];

    protected $casts = [
        'online_rate' => 'decimal:2',
        'offline_rate' => 'decimal:2',
        'is_online_available' => 'boolean',
        'is_offline_available' => 'boolean',
    ];

    public function tutorProfile()
    {
        return $this->belongsTo(TutorProfile::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
