<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Chat;
use App\Models\Pet;
use App\Models\Vet;
use App\Models\PetsHealth;
use App\Models\Veterinarian;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserAccessController;
use App\Http\Controllers\UserProcessController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\VetAccessController;
use App\Http\Controllers\VetProcessController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TestCreateData extends TestCase
{
    //テスト用獣医師データの作成
    public function CreateVet()
    {
        $data = [
            'name' => '山田一郎',
            'email' => 'yamada@example.com',
            'password' => 'securepassword123',
            'one_word' => '初めまして！山田と申します',
        ];
        $vetId = Vet::VetCreate($data);

        return $vetId;
    }

    //テスト用ユーザーデータの作成
    public function CreateUser()
    {
        $data = [
            'name' => '山田一郎',
            'email' => 'yamada@example.com',
            'password' => 'securepassword123',
        ];
        $userId = User::UserCreate($data);

        return $userId;
    }

    //テスト用ペットデータの作成
    public function CreatePet($userId)
    {
        $data = [
            'name' => 'ぽち',
            'age' => 2,
            'gender' => true,
            'type' => '柴犬',
            'birth' => '2024-05-01',
            'adoption' => '2024-05-13'
        ];
        $petId = Pet::PetCreate($userId, $data);

        return $petId;
    }

    //テスト用ペット健康データの作成
    public function CreatePetHealth($petId)
    {
        $data = [
            'date' => '2024/05/13',
            'weight' => 9.99,
            'breakfast_type' => '餌',
            'breakfast_amount' => 9.99,
            'lunch_type' => '餌',
            'lunch_amount' => 9.99,
            'dinner_type' => '餌',
            'dinner_amount' => 9.99,
            'medicine' => '薬',
            'walk' => 20,
            'trimming' => true,
            'toilet' => 1,
            'memo' => '食べ過ぎ'
        ];
        $petHealthId = PetsHealth::PetHealthCreate($petId, $data);

        return $petHealthId;
    }

    //テスト用チャットデータの作成
    public function CreateChat($userId, $vetId, $fromVet)
    {
        if($fromVet){
            $data = [
                'message' => '獣医師です！',
            ];
        }else{
            $data = [
                'message' => 'ユーザーです！',
            ];    
        }
        $chatid = User::ChatCreate($userId, $vetId, $data, $fromVet);

        return $chatid;
    }
}
