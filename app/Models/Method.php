<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Method extends Model
{
    use HasFactory;
    
    // Tradeに対するリレーション
    public function trades()
    {
        return $this->belongsToMany(Trade::class);
    }
}
