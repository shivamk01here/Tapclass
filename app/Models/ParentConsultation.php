<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentConsultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_user_id','child_id','contact_phone','questions','scheduled_at','status'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_user_id');
    }

    public function child()
    {
        return $this->belongsTo(ParentChild::class, 'child_id');
    }
}
