<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentChild extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_user_id', 'first_name', 'age', 'class_slab', 'goals', 'profile_photo_path'
    ];

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_user_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'child_id');
    }
}
