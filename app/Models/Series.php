<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    use HasFactory;
    
    //対応するテーブル名を明記
    protected $table = 'series';
    
    // Pictureに対するリレーション
    public function pictures()   
    {
        return $this->hasMany(Picture::class);  
    }
}
