<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Vet;
use App\Models\User;
use App\Models\Chat;
use App\Models\Pet;
use App\Models\PetsHealth;
use App\Models\Veterinarian;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class VetAccessController extends Controller
{
    /**
     * ホームページへ
     * 
     * @param string $selectPetId 表示したいペットのid、なければnull
     * @return mix ユーザー情報を返却
     */
    public function home($petId)
    {
        //ログインしていなければログインページへ
        $vetId = session('vet_id');
        if($vetId == null){
            $errorMessages = 'セッションが切れました';
            return view('vet.login', compact('errorMessages'));
        }

        //ユーザー、ペットの名前を取得
        $userList = User::select('user_id', 'name')->get();
        if($userList == null){
            //ユーザーが存在しない
            $errorMessages = 'ユーザーがいません';
            return view('vet.login', compact('errorMessages'));
        }
        $petList = Pet::select('pet_id', 'user_id', 'name')->get();
        if($userList == null){
            //ペットIDが存在しない
            $errorMessages = 'ペットデータが存在しません';
            return view('vet.login', compact('errorMessages'));
        }

        //ペットの情報を取得
        if($petId == null)
        {
            //ペットIDが入力されていない
            $petId = Pet::FindFirstPet($userList[0]->user_id);
            $petDetails = Pet::find($petId);
        }elseif(!$petList->contains('pet_id', $petId))
        {
            //ペットIDが存在しない
            $errorMessages = 'ペットデータが存在しません';
            return view('vet.login', compact('errorMessages'));
        }else{
            //ペットIDが存在
            $petDetails = Pet::find($petId);
        }

        //ユーザーIDを取得
        $userId = Pet::FindUser($petId);

        //ペットの健康情報を取得
        $today = date("Y/m/d");
        $todayHealthExists = PetsHealth::CheckTodayHealth($petId, $today);
        if($todayHealthExists)
        {
            //健康情報がある場合
            $todayHealth = PetsHealth::FindTodayHealth($petId, $today);
        }else{
            //健康情報がない場合
            $todayHealth = null;
        }

        //メッセージの取得
        $status = User::FindStatus($userId);
        if($status){
            $chatsList = Chat::FindMessage($userId);
        }else{
            $chatsList = null;
        }

        //ユーザーの名前を取得
        $userName = User::where('user_id', $userId)->value('name');

        //ホームへ
        return view('vet.home', compact('userList', 'petList', 'petDetails', 'todayHealth', 'status', 'chatsList', 'userId', 'userName'));
    }

    //ログインページへ
    public function login()
    {
        // セッションを削除
        session()->forget('vet_id');

        return view('vet.login');
    }

    //新規作成ページへ
    public function create()
    {
        // セッションを削除
        session()->forget('vet_id');

        return view('vet.create');
    }

    //会員情報ページへ
    public function profile()
    {
        //ログインしていなければログインページへ
        $vetId = session('vet_id');
        if($vetId == null){
        $errorMessages = 'セッションが切れました';
        return view('vet.login', compact('errorMessages'));
        }

        //ユーザー、ペットの名前を取得
        $userList = User::select('user_id', 'name')->get();
        if($userList == null){
            //ユーザーが存在しない
            $errorMessages = 'ユーザーがいません';
            return view('vet.login', compact('errorMessages'));
        }
        $petList = Pet::select('pet_id', 'user_id', 'name')->get();
        if($petList == null){
            //ペットが存在しない
            $errorMessages = 'ペットがいません';
            return view('vet.login', compact('errorMessages'));
        }

        //獣医師情報の取得
        $vet = Vet::find($vetId);

        // 会員情報ページへ
        return view('vet.profile', compact('userList', 'petList', 'vet'));
    }

    //会員情報編集ページへ
    public function edit()
    {
        //ログインしていなければログインページへ
        $vetId = session('vet_id');
        if($vetId == null){
        $errorMessages = 'セッションが切れました';
        return view('vet.login', compact('errorMessages'));
        }

        //ユーザー、ペットの名前を取得
        $userList = User::select('user_id', 'name')->get();
        $petList = Pet::select('pet_id', 'user_id', 'name')->get();

        //獣医師情報の取得
        $vet = Vet::find($vetId);

        // 会員情報編集ページへ
        return view('vet.edit', compact('userList', 'petList', 'vet'));
    }
}
