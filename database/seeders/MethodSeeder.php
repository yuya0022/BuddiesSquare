<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //以下のデータについては、既にテーブルに挿入済み.
        
        // DB::table('methods')->insert([
        //     'method' => '郵送',
        // ]);
        
        // DB::table('methods')->insert([
        //     'method' => '現地',
        // ]);
    }
}
