<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //以下のデータについては、既にテーブルに挿入済み.
        
        // $names = [
        //     [
        //         '石森虹花', '今泉佑唯', '上村莉菜', '尾関梨香', '織田奈那', '小池美波', '小林由依', '齋藤冬優花', '佐藤詩織', '志田愛佳',
        //         '菅井友香', '鈴本美愉', '長沢菜々香', '長濱ねる', '土生瑞穗', '原田葵', '平手友梨奈', '守屋茜', '米谷奈々未', '渡辺梨加', 
        //         '渡邉理佐'
        //     ],
        //     [
        //         '井上梨名', '遠藤光莉', '大園玲', '大沼晶保', '幸阪茉里乃', '関有美子', '武元唯衣', '田村保乃', '藤吉夏鈴', '増本綺良',
        //         '松田里奈', '松平璃子', '森田ひかる', '守屋麗奈', '山崎天'
 
        //     ],
        //     [
        //         '石森璃花', '遠藤理子', '小田倉麗奈', '小島凪紗', '谷口愛季', '中嶋優月', '的野美青', '向井純葉', '村井優', '村山美羽',
        //         '山下瞳月'
        //     ]
        // ];
        
        // for($i = 0; $i < 3; $i++){
        //     foreach($names[$i] as $name){
        //         DB::table('members')->insert([
        //                 'generation' => $i + 1,
        //                 'name' => $name,
        //         ]);
        //     }
        // }
    }
}
