<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class MethodTrade extends Pivot
{
    use HasFactory;
    
    //対応するテーブル名を明記
    protected $table = 'method_trade';
    
    // EventInfoに対するリレーション
    public function event_info()
    {
        return $this->belongsTo(EventInfo::class);
    }
}
