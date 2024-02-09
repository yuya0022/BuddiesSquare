<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        //以下のデータについては、既にテーブルに挿入済み.
        // 今後、イベント名データを追加していく場合は、$namesの値を適切に変更する.
        
        // $names = [
        //     '欅坂46 生中継! デビューカウントダウンライブ!', '欅坂46 デビューシングル「サイレントマジョリティー」発売記念 全国握手会', 
        //     '欅坂46 デビューシングル「サイレントマジョリティー」発売記念 個別握手会', '欅坂46 2ndシングル「世界には愛しかない」発売記念 全国握手会',
        //     '欅坂46 2ndシングル「世界には愛しかない」発売記念 個別握手会', '欅坂46 3rdシングル「二人セゾン」発売記念 個別握手会',
        //     '欅坂46 3rdシングル「二人セゾン」発売記念 全国握手会', '欅坂46 ワンマンライブ',
        //     '欅坂46 デビュー1周年記念ライブ', '欅坂46 4thシングル「不協和音」発売記念 個別握手会',
        //     '欅坂46 4thシングル「不協和音」発売記念 全国握手会', '欅共和国2017',
        //     '欅坂46 1stアルバム「真っ白なものは汚したくなる」発売記念 個別握手会', '欅坂46 全国ツアー2017「真っ白なものは汚したくなる」',
        //     '欅坂46 5thシングル「風に吹かれても」発売記念 個別握手会', '欅坂46 5thシングル「風に吹かれても」発売記念 全国握手会',
        //     '欅坂46 6thシングル「ガラスを割れ!」発売記念 個別握手会', '欅坂46 6thシングル「ガラスを割れ!」発売記念 全国握手会',
        //     '欅坂46 2nd YEAR ANNIVERSARY LIVE', '欅共和国2018',
        //     '欅坂46 夏の全国アリーナツアー2018', '欅坂46 渋谷ストリームホール こけら落としミニライブ',
        //     '欅坂46 7thシングル「アンビバレント」発売記念 個別握手会', '欅坂46 7thシングル「アンビバレント」発売記念 全国握手会',
        //     '欅坂46 8thシングル「黒い羊」発売記念 全国握手会', '欅坂46 8thシングル「黒い羊」発売記念 個別握手会',
        //     '欅坂46 3rd YEAR ANNIVERSARY LIVE', '欅坂46 二期生「おもてなし会」',
        //     '欅共和国2019', '欅坂46 夏の全国アリーナツアー2019',
        //     'KEYAKIZAKA46 Live Online, but with YOU!', 'KEYAKIZAKA46 Live Online, AEON CARD with YOU!',
        //     '欅坂46 THE LAST LIVE',
            
        //     '櫻坂46「デビューカウントダウンライブ!!」', '櫻坂46「BACKS LIVE!!」',
        //     'W-KEYAKI FES. 2021', '櫻坂46「1st TOUR 2021」',
        //     '櫻坂46「1st YEAR ANNIVERSARY LIVE」', '櫻坂46「3rd Single BACKS LIVE!!」',
        //     '櫻坂46「渡邉理佐 卒業コンサート」', 'W-KEYAKI FES. 2022',
        //     '櫻坂46「2nd TOUR 2022 "As you know?"」', '櫻坂46「2nd YEAR ANNIVERSARY ～Buddies 感謝祭～」',
        //     'SAKURAZAKA46 Live, AEON CARD with YOU! Vol.2', '櫻坂46 三期生「おもてなし会」',
        //     '櫻坂46「3rd TOUR 2023」', '櫻坂46 6th Single「Start over!」発売記念リアルミート&グリート',
        //     '櫻坂46「新参者 LIVE at THEATER MILANO-Za」', '櫻坂46「3rd YEAR ANNIVERSARY LIVE」',
        //     '櫻坂46 7th Single「承認欲求」発売記念リアルミート&グリート', '櫻坂46「7th Single BACKS LIVE!!」',
        //     '櫻坂46「小林由依 卒業コンサート」', '櫻坂46「全国アリーナツアー」'
        // ];
        
        // foreach($names as $name){
        //     DB::table('events')->insert([
        //         'name' => $name,
        //     ]);
        // }
        
    }
}
