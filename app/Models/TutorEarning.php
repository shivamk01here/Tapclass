<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorEarning extends Model
{
    use HasFactory;

    protected $fillable = [
        'tutor_id',
        'booking_id',
        'amount',
        'status',
        'withdrawn_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'withdrawn_at' => 'datetime',
    ];

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
