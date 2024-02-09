<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
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
        //     '連番募集', '当落報告', '座席報告', '会場で会える人を募集', '集合写真',
        //     '祝花', 'Q&A', '参戦者への共有事項', 'ライブ前トーク', 'ライブ後トーク（ネタバレ含む）',
        //     'その他'
        // ];
        
        // foreach($names as $name){
        //     DB::table('categories')->insert([
        //         'name' => $name,
        //     ]);
        // }
        
    }
}
