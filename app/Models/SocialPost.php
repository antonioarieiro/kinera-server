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
        'content',
        'likes',
        'dislikes',
        'republish',
        'type',
        'address',
        'is_festival',
        'is_rankings',
        'categorie',
        'tag',
        'event_id',
        'urls'
    ];
    public $timestamps = true;

    public function userProfile()
    {
        return $this->belongsTo(UserProfile::class, 'user_id');
    }
}
