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

class TestVetModel extends TestCase
{
    //リセット
    use RefreshDatabase;

    /**
     * @test
     */
    public function testSuccess()
    {
        // リクエストを作成
        $data = [
            'name' => '山田一郎',
            'email' => 'yamada@example.com',
            'password' => 'securepassword123',
            'one_word' => '初めまして！山田と申します',
        ];

        // テスト用の関数を呼び出し
        $response = Vet::VetCreate($data);

        //返り値の確認
        $this->assertIsInt($response);

        //DBに登録されたデータの確認
        $this->assertDatabaseHas('vets', [
            'user_id' => $response,
            'name' => '山田一郎',
            'email' => 'yamada@example.com',
            'one_word' => '初めまして！山田と申します',
        ]);
        // パスワードの確認
        $vet = Vet::find($response);
        $this->assertTrue(Hash::check('securepassword123', $vet->password));
    }

    /**
     * @test
     */
    public function testError()
    {
        // リクエストを作成
        $data = [
            'name' => '山田一郎',
            'email' => 'yamada@example.com',
            'password' => 'securepassword123',
            'one_word' => '初めまして！山田と申します',
        ];

        // テスト用の関数を呼び出し
        $response = User::UserCreate(null);

        //返り値の確認(false)
        $this->assertFalse($response);
    }
}
