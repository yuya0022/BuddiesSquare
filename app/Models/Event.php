<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    
    //EventInfoに対するリレーション
    public function event_info()
    {
        return $this->hasMany(EventInfo::class);  
    }
    
}
