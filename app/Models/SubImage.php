<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubImage extends Model
{
    use HasFactory;
    
    // timestampsの更新を無効にする
    public $timestamps = false;
    
    protected $fillable = [
        'user_id',
        'path',
    ];
    
    // Userに対するリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
