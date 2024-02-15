<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Following extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'followings';
    protected $fillable = ['user_id', 'address', 'name', 'img', 'follow_name', 'follower_id'];

    // Defina as relações, se houver
}
