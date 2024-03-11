<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notifications';
    protected $fillable = [
        'user_id',
        'type',
        'content',
        'status',
    ];
    public $timestamps = true;

    public function userProfile()
    {
        return $this->belongsTo(UserProfile::class, 'user_id');
    }
}
