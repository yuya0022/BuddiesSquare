<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;
    
    // Pictureに対するリレーション
    public function pictures()   
    {
        return $this->hasMany(Picture::class);  
    }
}
