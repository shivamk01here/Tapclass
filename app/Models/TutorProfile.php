<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bio',
        'experience_years',
        'education',
        'location',
        'latitude',
        'longitude',
        'government_id_path',
        'degree_certificate_path',
        'cv_path',
        'verification_status',
        'verification_notes',
        'is_verified_badge',
        'average_rating',
        'total_sessions',
        'total_reviews',
        'total_likes',
        'hourly_rate',
        'teaching_mode',
        'city',
        'state',
'qualification',
        'gender',
        'travel_radius_km',
        'grade_levels',
        'onboarding_completed',
        'onboarding_step',
    ];

    protected $casts = [
        'is_verified_badge' => 'boolean',
        'average_rating' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
'onboarding_completed' => 'boolean',
        'grade_levels' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'tutor_subjects', 'tutor_profile_id', 'subject_id')
                    ->withPivot('online_rate', 'offline_rate', 'is_online_available', 'is_offline_available')
                    ->withTimestamps();
    }

    public function tutorSubjects()
    {
        return $this->hasMany(TutorSubject::class);
    }

    public function availability()
    {
        return $this->hasMany(TutorAvailability::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'tutor_id');
    }

    public function likes()
    {
        // Likes are stored against the tutor's user_id, not the tutor_profiles.id
        return $this->hasMany(TutorLike::class, 'tutor_id', 'user_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'tutor_id');
    }

    public function earnings()
    {
        return $this->hasMany(TutorEarning::class, 'tutor_id');
    }

    public function isPending()
    {
        return $this->verification_status === 'pending';
    }

    public function isVerified()
    {
        return $this->verification_status === 'verified';
    }

    public function isRejected()
    {
        return $this->verification_status === 'rejected';
    }
}
