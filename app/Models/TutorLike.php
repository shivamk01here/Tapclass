<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'tutor_id',
    ];

    public $timestamps = false;
    
    protected $dates = ['created_at'];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }
}
