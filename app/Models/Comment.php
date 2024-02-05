<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'post_comment';
    protected $fillable = [
        'post_id',
        'content',
        'likes',
        'dislikes',
        'address',
        'img',
        'name',
        'parent',
        'user_id'
    ];
    public $timestamps = true;

    public function userProfile()
    {
        return $this->belongsTo(UserProfile::class, 'user_id');
    }
}
