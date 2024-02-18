<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'user_id',
        'event_id',
        'category_id',
        'body',
    ];
    
    // Categoryに対するリレーション
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    // Eventに対するリレーション
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    
    // Userに対するリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // PostCommentに対するリレーション
    public function post_comments()   
    {
        return $this->hasMany(PostComment::class);
    }
}
