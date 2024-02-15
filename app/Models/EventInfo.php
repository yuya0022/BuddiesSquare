<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventInfo extends Model
{
    use HasFactory;
    
    //対応するテーブル名を明記
    protected $table = 'event_info';
    
    //Eventに対するリレーション
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    
    // Userに対するリレーション
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    
}
