<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Hash; 

class DataRemoverSeeder extends Seeder
{
    /**
     * 各テーブルのデータを消去
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        DB::table('pets')->delete();
        DB::table('petsHealth')->delete();
        DB::table('veterinarians')->delete();
        DB::table('chats')->delete();
    }
}
