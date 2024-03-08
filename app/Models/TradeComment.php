<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TradeComment extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'user_id',
        'trade_id',
        'comment',
    ];
    
    // Userに対するリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Tradeに対するリレーション
    public function trade()
    {
        return $this->belongsTo(Trade::class);
    }
}
