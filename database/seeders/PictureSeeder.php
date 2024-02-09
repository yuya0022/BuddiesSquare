<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PictureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 既に、シリーズidの1~4については、以下の通りにデータを挿入済み.
        
        // $members = [3, 4, 6, 7, 8, 11, 15, 16, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36];
        
        // for($i = 1; $i <= 4; $i++){
        //     foreach($members as $member){
        //         for($j = 1; $j <= 4; $j++){
        //             DB::table('pictures')->insert([
        //                 'series_id' => $i,
        //                 'member_id' => $member,
        //                 'type_id' => $j,
        //             ]);
        //         }
        //     }
        // }
        
    }
}
