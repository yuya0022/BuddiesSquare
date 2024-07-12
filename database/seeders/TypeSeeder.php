<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //以下のデータについては、既にテーブルに挿入済み.
        // 今後、生写真のタイプ名データを追加していく場合は、$namesの値を適切に変更する.
        
        $names = [
            'ヨリ', 'チュウ', 'ヒキ', '座り'
        ];
        
        foreach($names as $name){
            DB::table('types')->insert([
                'name' => $name,
            ]);
        }
    }
}
