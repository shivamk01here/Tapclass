<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiMockTest extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'questions_json' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
