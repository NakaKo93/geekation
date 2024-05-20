<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Chat;
use App\Models\Pet;
use App\Models\PetsHealth;
use App\Models\Veterinarian;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserAccessController;
use App\Http\Controllers\UserProcessController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\VetAccessController;
use App\Http\Controllers\VetProcessController;
use Tests\Feature\TestCreateData;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TestPetHealthModel extends TestCase
{
    //リセット
    use RefreshDatabase;

    /**
     * @test
     */
    public function testSuccess()
    {
        // 必要なDBの作成
        $userId = TestCreateData::CreateUser();
        $petId = TestCreateData::CreatePet($userId);

        // リクエストを作成
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

        // テスト用の関数を呼び出し
        $response = PetsHealth::PetHealthCreate($petId, $data);

        //返り値の確認
        $this->assertIsInt($response);

        //DBに登録されたデータの確認
        $this->assertDatabaseHas('petsHealth', [
            'pethealth_id' => $response,
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
        ]);
    }

    /**
     * @test
     */
    public function testError()
    {
        // 必要なDBの作成
        $userId = TestCreateData::CreateUser();
        $petId = TestCreateData::CreatePet($userId);
        
        // リクエストを作成
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

        // テスト用の関数を呼び出し
        $response = PetsHealth::PetHealthCreate($petId, null);

        //返り値の確認(false)
        $this->assertFalse($response);
    }
}
