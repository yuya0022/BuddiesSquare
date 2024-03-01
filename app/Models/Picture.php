<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    use HasFactory;
    
    // Memberに対するリレーション
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
    
    // Typeに対するリレーション
    public function type()
    {
        return $this->belongsTo(Type::class);
    }
    
    // Seriesに対するリレーション
    public function series()
    {
        return $this->belongsTo(Series::class);
    }
    
    // Tradeに対するリレーション
    public function trades()
    {
        return $this->belongsToMany(Trade::class);
    }
}
