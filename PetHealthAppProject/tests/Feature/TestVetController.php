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

class TestVetController extends TestCase
{
    //リセット
    use RefreshDatabase;

    /**
     * @test
     */
    public function testSuccess()
    {
        // 現在のページを設定
        $this->from('http://localhost/vet/create');

        // 必要なDBの作成
        $userId = TestCreateData::CreateUser();
        $petId = TestCreateData::CreatePet($userId);
        //$vetId = TestCreateData::CreateUser();
        
        // 必要なセッションの登録
        //session(['vet_id' => $vetId]);

        // リクエストを作成
        $request = Request::create('vet.create-process', 'POST', [
            'name' => '山田一郎',
            'email' => 'yamada@example.com',
            'password' => 'securepassword123',
            'one_word' => '初めまして！山田と申します',
        ]);

        // テスト用の関数を呼び出し
        $controller = new VetProcessController();
        $response = $controller->createProcess($request);

        //302(リダイレクト)か確認
        $this->assertEquals(302, $response->getStatusCode());

        //リダイレクト先を確認
        $this->assertEquals(route('vet.home', ['petId' => $petId]), $response->headers->get('Location'));
        //$this->assertEquals(route('vet.home'), $response->headers->get('Location'));
    }

    /**
     * @test
     */
    public function testError()
    {
        // 現在のページを設定
        $this->from('http://localhost/vet/create');

        // 必要なDBの作成
        $userId = TestCreateData::CreateUser();
        $petId = TestCreateData::CreatePet($userId);
        //$vetId = TestCreateData::CreateUser();
        
        // 必要なセッションの登録
        //session(['vet_id' => $vetId]);
        
        // リクエストを作成
        $request = Request::create('vet.create-process', 'POST', [
            'name' => '',
            'email' => 'yamada@example.com',
            'password' => 'securepassword123',
            'one_word' => '初めまして！○○です',
        ]);

        // テスト用の関数を呼び出し
        $controller = new VetProcessController();
        $response = $controller->createProcess($request);

        //302(リダイレクト)か確認
        $this->assertTrue($response->isRedirect());
        $this->assertEquals(302, $response->getStatusCode());

        //リダイレクト先を確認
        $this->assertEquals(route('vet.create'), $response->headers->get('Location'));

        //バリデーションエラーのデータを確認
        $this->followRedirects($response)->assertSessionHasErrors([
            'name' => '名前を入力してください',
        ]);
    }
}
