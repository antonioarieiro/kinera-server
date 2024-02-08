<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialPost extends Model
{
    use HasFactory;
    protected $table = 'social_post';
    protected $fillable = [
        'user_id',
        'address'
    ];
    public $timestamps = true;

    public function userProfile()
    {
        return $this->belongsTo(UserProfile::class, 'user_id');
    }
}
