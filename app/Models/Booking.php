<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'student_id',
        'tutor_id',
        'subject_id',
        'session_type',
        'session_date',
        'session_start_time',
        'session_end_time',
        'session_duration_minutes',
        'amount',
        'platform_commission',
        'tutor_earnings',
        'status',
        'meet_link',
        'location_address',
        'location_latitude',
        'location_longitude',
        'cancellation_reason',
        'cancelled_by',
    ];

    protected $casts = [
        'session_date' => 'date',
        'amount' => 'decimal:2',
        'platform_commission' => 'decimal:2',
        'tutor_earnings' => 'decimal:2',
        'location_latitude' => 'decimal:8',
        'location_longitude' => 'decimal:8',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function earning()
    {
        return $this->hasOne(TutorEarning::class);
    }

    public function isOnline()
    {
        return $this->session_type === 'online';
    }

    public function isOffline()
    {
        return $this->session_type === 'offline';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isConfirmed()
    {
        return $this->status === 'confirmed';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }
}
