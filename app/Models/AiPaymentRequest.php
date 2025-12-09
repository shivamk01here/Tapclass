<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiPaymentRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan',
        'amount',
        'utr',
        'screenshot_path',
        'status',
        'admin_notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
