<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    
    // timestampsの更新を無効にする
    public $timestamps = false;
    
    protected $fillable = [
        'user_id',
        'answer_1',
        'answer_2',
        'answer_3',
        'answer_4',
        'answer_5',
        'answer_6',
    ];
    
    // Userに対するリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
