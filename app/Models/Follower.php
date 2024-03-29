<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $table = 'followers';
    protected $fillable = [
        'user_id',
        'address',
        'name',
        'img',
        'follow_name',
        'follower_id'
    ];
 
}
