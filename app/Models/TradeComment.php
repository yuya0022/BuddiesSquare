<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeComment extends Model
{
    use HasFactory;
    
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
