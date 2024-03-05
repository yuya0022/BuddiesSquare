<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'note',
    ];
    
    // Userに対するリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // TradeCommentに対するリレーション
    public function trade_comments()   
    {
        return $this->hasMany(TradeComment::class);  
    }
    
    // Methodに対するリレーション
    public function methods()
    {
        return $this->belongsToMany(Method::class, 'method_trade')
                    ->using(MethodTrade::class)->withPivot(['event_info_id']);
    }
    
    // Pictureに対するリレーション
    public function pictures()
    {
        return $this->belongsToMany(Picture::class);
    }
}
