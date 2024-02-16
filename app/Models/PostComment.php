<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    use HasFactory;
    
    // Userに対するリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Postに対するリレーション
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
