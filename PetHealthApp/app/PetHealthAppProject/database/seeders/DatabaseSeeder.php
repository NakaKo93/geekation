<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Hash; 

class DatabaseSeeder extends Seeder
{
    /**
     * 各テーブルにモデルを使用してデータを入力
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::create([
            [
                'name' => 'test ichirou',
                'email'     => Str::random(10).'@gmail.com',
                'password'  => Hash::make('password'),
                'status' => true
            ]
        ]);

        $user2 = User::create([
            [
                'name' => 'test zirou',
                'email'     => Str::random(10).'@gmail.com',
                'password'  => Hash::make('password'),
                'status' => false
            ]
        ]);
        
        $pets1 = User::create([
            [
                'user_id'   =>  $user1->id,
                'photo_address'     => 'PetHealthAppProject/public/'.Str::random(10),
                'name'  => 'ichi',
                'age' => 3,
                'gender' => true,
                'type'     => 'mikeneko',
                'birth'  => '2020/01/01',
                'adoption' => '2022/02/02',
                'memo' => 'hellow'
            ]
        ]);

        $pets2 = User::create([
            [
                'user_id'   =>  $user2->id,
                'photo_address'     => 'PetHealthAppProject/public/'.Str::random(10),
                'name'  => 'ni',
                'age' => 5,
                'gender' => false,
                'type'     => 'sibainu',
                'birth'  => '2023/03/03',
                'adoption' => '2024/04/04',
                //'memo' => ''
            ]
        ]);
    }
}
