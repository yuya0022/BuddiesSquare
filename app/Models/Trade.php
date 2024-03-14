<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trade extends Model
{
    use HasFactory;
    use SoftDeletes;
    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
     
    protected $softCascade = ['trade_comments']; 
    
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
