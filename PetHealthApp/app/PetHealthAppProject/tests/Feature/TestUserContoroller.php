<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
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

class TestUserContoroller extends TestCase
{
    //リセット
    use RefreshDatabase;

    /**
     * @test
     */
    public function testSuccess()
    {
        // 現在のページを設定
        $this->from('http://localhost/user/create');

        // 必要なDBの作成
        //$userId = TestCreateData::CreateUser();
        //$petId = TestCreateData::CreatePet($userId);

        // 必要なセッションの登録
        //session(['user_id' => $userId]);
        
        // リクエストを作成
        $request = Request::create('user.create-process', 'POST', [
            'name' => '山田一郎',
            'email' => 'yamada@example.com',
            'password' => 'securepassword123'
        ]);

        // テスト用の関数を呼び出し
        $controller = new UserProcessController();
        $response = $controller->createProcess($request);

        //302(リダイレクト)か確認
        $this->assertEquals(302, $response->getStatusCode());

        //リダイレクト先を確認
        $this->assertEquals(route('user.pet.create'), $response->headers->get('Location'));

        //セッションのデータを確認
        //$this->assertEquals(, session('status'));
    }

    /**
     * @test
     */
    public function testError()
    {
        // 現在のページを設定
        $this->from('http://localhost/user/create');

        // 必要なDBの作成
        //$userId = TestCreateData::CreateUser();
        //$petId = TestCreateData::CreatePet($userId);

        // 必要なセッションの登録
        //session(['user_id' => $userId]);
        
        // リクエストを作成
        $request = Request::create('user.create-process', 'POST', [
            'name' => '',
            'email' => 'yamada@example.com',
            'password' => 'securepassword123'
        ]);

        // テスト用の関数を呼び出し
        $controller = new UserProcessController();
        $response = $controller->createProcess($request);

        //302(リダイレクト)か確認
        $this->assertTrue($response->isRedirect());
        $this->assertEquals(302, $response->getStatusCode());

        //リダイレクト先を確認
        $this->assertEquals(route('user.create'), $response->headers->get('Location'));

        //セッションのデータを確認
        //$this->assertEquals(, session('status'));

        //バリデーションエラーのデータを確認
        $this->followRedirects($response)->assertSessionHasErrors([
            'name' => '名前を入力してください',
        ]);
    }
}
