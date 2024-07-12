<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //以下のデータについては、既にテーブルに挿入済み.
        // 今後、生写真のシリーズ名データを追加していく場合は、$datesや$namesの値を適切に変更する.
        
        $dates = [
            '2020-12-09', '2020-12-17', '2021-01-21', '2021-02-18', '2021-04-14',
            '2021-04-30', '2021-05-15', '2021-06-18', '2021-07-09', '2021-09-07',
            '2021-10-15', '2021-10-29', '2021-12-09', '2022-01-08'
        ];
        
        $names = [
            [
                "1stシングル「Nobody's fault」封入生写真"
            ],
            [
                "Nobody's fault衣装", 'クリスマスサンタ衣装', '冬私服コーディネート衣装'
            ],
            [
                '2021年振袖衣装'
            ],
            [
                "「Nobody's fault」MVロケーション制服衣装", '「なぜ 恋をして来なかったんだろう?」MVロケーション衣装', '「Buddies」MVロケーション衣装'
            ],
            [
                '2ndシングル「BAN」封入生写真'
            ],
            [
                "「Nobody's fault」カップリング楽曲TVパフォーマンス衣装", '2020年歌番組衣装'
            ],
            [
                'ラストライブDay1衣装', 'ラストライブDay2衣装'
            ],
            [
                '「BACKS LIVE!!」メインビジュアル用MV衣装', '「BACKS LIVE!!」メインビジュアル用私服衣装'
            ],
            [
                '「BAN」MVロケーション衣装', '「偶然の答え」MVロケーション衣装', '「思ったよりも寂しくない」MVロケーション衣装'
            ],
            [
                '「BAN」歌番組衣装', '2021年浴衣衣装', '2021年夏私服コーディネート衣装'
            ],
            [
                '3rdシングル「流れ弾」封入生写真'  
            ],
            [
                '「流れ弾」MVロケーション衣装', '「Dead end」MVロケーション衣装', '「無言の宇宙」MV衣装'
            ],
            [
                '2021年クリスマスサンタ衣装', '「1st TOUR 2021」ライブオープニング衣装', '「流れ弾」MV黒衣装', '「無言の宇宙」MVスタイリング衣装'
            ],
            [
                '3rd Single「BACKS LIVE!!」ビジュアルMV衣装', '2022年振袖衣装', '「流れ弾」ジャケット写真衣装'
            ],
        ];
        
        for($i = 0; $i < count($dates); $i++){
            foreach($names[$i] as $name){
                DB::table('series')->insert([
                    'name' => $name,
                    'released_on' => $dates[$i],
                ]);
            }
        }
    }
}
