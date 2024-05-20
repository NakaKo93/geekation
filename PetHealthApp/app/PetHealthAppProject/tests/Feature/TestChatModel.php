<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
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
use Tests\Feature\TestCreateData;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TestChatModel extends TestCase
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
        $vetId = TestCreateData::CreateVet();

        // リクエストを作成
        $data = [
            'message' => '初めまして！',
        ];
        $fromVet = True;

        // テスト用の関数を呼び出し
        $response = Chat::ChatCreate($userId, $vetId, $data, $fromVet);

        //返り値の確認
        $this->assertIsInt($response);

        //DBに登録されたデータの確認
        $this->assertDatabaseHas('chats', [
            'chats_id' => $response,
            'user_id' => $userId,
            'vet_id' => $vetId,
            'message' => '初めまして！',
            'from_vet' => $fromVet,
        ]);
    }

    /**
     * @test
     */
    public function testError()
    {
        // 必要なDBの作成
        $userId = TestCreateData::CreateUser();
        $vetId = TestCreateData::CreateVet();

        // リクエストを作成
        $data = [
            'message' => '初めまして！',
        ];
        $fromVet = True;

        // テスト用の関数を呼び出し
        $response = Chat::ChatCreate($userId, $vetId, null, $fromVet);

        //返り値の確認(false)
        $this->assertFalse($response);
    }
}
