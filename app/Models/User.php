<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'main_image',
        'birthday',
        'sex',
        'residence',
        'x_user_name',
        'status_message',
        'fan_career',
        'self-introduction',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    // SubImageに対するリレーション
    public function sub_images()
    {
        return $this->hasMany(SubImage::class);
    }
    
    // Answerに対するリレーション
    public function answer()
    {
        return $this->hasOne(Answer::class);
    }    
    
    // Memberに対するリレーション
    public function members()
    {
        return $this->belongsToMany(Member::class);
    }
    
    // Songに対するリレーション
    public function songs()
    {
        return $this->belongsToMany(Song::class);
    }
    
    // EventInfoに対するリレーション
    public function event_info()
    {
        return $this->belongsToMany(EventInfo::class);
    }
    
    // Postに対するリレーション
    public function posts()   
    {
        return $this->hasMany(Post::class);  
    }
    
    // PostCommentに対するリレーション
    public function post_comments()   
    {
        return $this->hasMany(PostComment::class);
    }
    
    // Tradeに対するリレーション
    public function trades()   
    {
        return $this->hasMany(Trade::class);  
    }
    
    // TradeCommentに対するリレーション
    public function trade_comments()   
    {
        return $this->hasMany(TradeComment::class);  
    }
}
