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

class TestUserModel extends TestCase
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
            'password' => 'securepassword123'
        ];

        // テスト用の関数を呼び出し
        $response = User::UserCreate($data);

        //返り値の確認
        $this->assertIsInt($response);

        //DBに登録されたデータの確認
        $this->assertDatabaseHas('users', [
            'user_id' => $response,
            'name' => '山田一郎',
            'email' => 'yamada@example.com',
        ]);
        // パスワードの確認
        $user = User::find($response);
        $this->assertTrue(Hash::check('securepassword123', $user->password));
    }

    /**
     * @test
     */
    public function testError()
    {
        // リクエストを作成
        $data = [
            'name' => "山田一郎",
            'email' => 'yamada@example.com',
            'password' => 'securepassword123'
        ];

        // テスト用の関数を呼び出し
        $response = User::UserCreate(null);

        //返り値の確認(false)
        $this->assertFalse($response);

        // DBに登録されていないことを確認
        $this->assertDatabaseMissing('users', [
            'email' => 'yamada@example.com',
        ]);
    }
}
