<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    
    //対応するテーブル名を明記
    protected $table = 'chats';
    
    //Messageに対するリレーション
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
