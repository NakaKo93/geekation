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
use Tests\Feature\TestCreateData;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TestPetController extends TestCase
{
    //リセット
    use RefreshDatabase;

    /**
     * @test
     */
    public function testSuccess()
    {
        // 現在のページを設定
        $this->from('http://localhost/pet/create');

        // 必要なDBの作成
        //$petId = TestCreateData::CreatePet($userId);
        $userId = TestCreateData::CreateUser();

        // 必要なセッションの登録
        session(['user_id' => $userId]);
        
        // リクエストを作成
        $request = Request::create('user.pet.create-process', 'POST', [
            'name' => 'ぽち',
            'age' => 2,
            'gender' => true,
            'type' => '柴犬',
            'birth' => '2024-05-01',
            'adoption' => '2024-05-13'
        ]);

        // テスト用の関数を呼び出し
        $controller = new PetController();
        $response = $controller->petCreateProcess($request);

        //302(リダイレクト)か確認
        $this->assertTrue($response->isRedirect());
        $this->assertEquals(302, $response->getStatusCode());

        //リダイレクト先を確認
        $this->assertEquals(route('user.home', ['petId' => 1]), $response->headers->get('Location'));
        //$this->assertEquals(route('vet.home'), $response->headers->get('Location'));
    }

    /**
     * @test
     */
    public function testError()
    {
        // 現在のページを設定
        $this->from('http://localhost/user/pet/create');

        // 必要なDBの作成
        //$petId = TestCreateData::CreatePet($userId);
        $userId = TestCreateData::CreateUser();

        // 必要なセッションの登録
        session(['user_id' => $userId]);
        
        // リクエストを作成
        $request = Request::create('user.pet.create-process', 'POST', [
            'name' => '',
            'age' => 2,
            'gender' => true,
            'type' => '柴犬',
            'birth' => '2024-05-01',
            'adoption' => '2024-05-13'
        ]);

        // テスト用の関数を呼び出し
        $controller = new PetController();
        $response = $controller->petCreateProcess($request);

        //302(リダイレクト)か確認
        $this->assertTrue($response->isRedirect());
        $this->assertEquals(302, $response->getStatusCode());

        //リダイレクト先を確認
        $this->assertEquals(route('user.pet.create'), $response->headers->get('Location'));

        //バリデーションエラーのデータを確認
        $this->followRedirects($response)->assertSessionHasErrors([
            'name' => '名前を入力してください',
        ]);
    }
}
