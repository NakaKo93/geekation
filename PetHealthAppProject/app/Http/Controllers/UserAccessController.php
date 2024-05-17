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

class UserAccessController extends Controller
{
    /**
     * ホームページへ
     * 
     * @param string $selectPetId 表示したいペットのid、なければnull
     * @return mix 登録したユーザー情報を返却
     */
    public function home($petId)
    {
        //ログインしていなければログインページへ
        $userId = session('user_id');
        if($userId == null){
            $errorMessages = 'セッションが切れました';
            return view('user.login', compact('errorMessages'));
        }

        //ペットが登録されていなければ新規作成ページへ
        $petDataExists = Pet::FindFirstPet($userId);
        if($petDataExists == false)
        {
            // ペット新規登録ページへ
            return redirect()->route('user.pet.create');
        }

        //ペットの名前、健康状態記入の有無を取得
        $petNames = Pet::FindPetNames($userId);
        $today = date("Y/m/d");
        foreach ($petNames as $index => $petDeta)
        {
            $healthDataExists = PetsHealth::FindTodayHealth($petDeta['pet_id'], $today);
            if($healthDataExists == null)
            {
                $petNames[$index]['message'] = '今日の状態を記入しましょう';
            }
        }
        $petList = $petNames;

        //ペットの情報を取得
        if($petId == null)
        {
            $petId = Pet::FindFirstPet($userId);
            $petDetails = Pet::find($petId);
        }else{
            $petDetails = Pet::find($petId);
        }

        //今日の健康情報を取得
        $todayHealthExists = PetsHealth::CheckTodayHealth($petId, $today);
        if($todayHealthExists)
        {
            //健康情報がある場合
            $todayHealth = PetsHealth::FindTodayHealth($petId, $today);
            $bottonMessage = '更新';
        }else{
            //健康情報がない場合
            $todayHealth = null;
            $bottonMessage = '提出';
        }

        //会員ステータスを取得
        $status = User::FindStatus($userId);
        if($status)
        {
            //メッセージの取得
            $chatsList = Chat::FindMessage($userId);
            if($chatsList == false)
            {
                $chatsList = null;
                $vetName = null;
            }else{
                //獣医師の名前を取得
                $vetId = $chatsList[0]->vet_id;
                $vetName = Vet::where('vet_id', $vetId)->value('name');
            }
        }else{
            $chatsList = null;
            $vetName = null;
        }

        //ホームページへ
        return view('user.home', compact('petList', 'petDetails', 'today', 'todayHealth', 'bottonMessage', 'status', 'chatsList', 'vetName'));
    }

    //ユーザーのログインページへ
    public function login()
    {
        // セッションの削除
        session()->forget('user_id');

        //ログインページへ
        return view('user.login');
    }

    //ユーザー新規作成ページへ
    public function create()
    {
        // セッションの削除
        session()->forget('user_id');

        //新規登録ページへ
        return view('user.create');
    }

    //有料会員登録ページへ
    public function premium()
    {
        //ログインしていなければログインページへ
        $userId = session('user_id');
        if($userId == null){
            $errorMessages = 'セッションが切れました';
            return view('user.login', compact('errorMessages'));
        }

        //有料会員の場合ホームページへ移動
        $status = User::FindStatus($userId);
        if($status)
        {
            return redirect()->route('user.home');
        }

        //ペットが登録されていなければ新規作成ページへ
        $petDataExists = Pet::FindFirstPet($userId);
        if($petDataExists == false)
        {
            return redirect()->route('user.pet.create');
        }

        //ペットの名前、健康状態記入の有無を取得
        $petNames = Pet::FindPetNames($userId);
        $today = date("Y/m/d");
        foreach ($petNames as $index => $petDeta)
        {
            $healthDataExists = PetsHealth::FindTodayHealth($petDeta['pet_id'], $today);
            if($healthDataExists == null)
            {
                $petNames[$index]['message'] = '今日の状態を記入しましょう';
            }
        }
        $petList = $petNames;

        // 有料会員登録ページ
        return view('user.premium', compact('petList'));
    }

    //ユーザー会員情報ページへ
    public function profile()
    {
        //ログインしていなければログインページへ
        $userId = session('user_id');
        if($userId == null){
            $errorMessages = 'セッションが切れました';
            return view('user.login', compact('errorMessages'));
        }

        //ペットが登録されていなければ新規作成ページへ
        $petDataExists = Pet::FindFirstPet($userId);
        if($petDataExists == false)
        {
            return redirect()->route('user.pet.create');
        }

        //ペットの名前、健康状態記入の有無を取得
        $petNames = Pet::FindPetNames($userId);
        $today = date("Y/m/d");
        foreach ($petNames as $index => $petDeta)
        {
            $healthDataExists = PetsHealth::FindTodayHealth($petDeta['pet_id'], $today);
            if($healthDataExists == null)
            {
                $petNames[$index]['message'] = '今日の状態を記入しましょう';
            }
        }
        $petList = $petNames;

        //ユーザー情報の取得
        $user = User::find($userId);

        // 会員情報ページへ
        return view('user.profile', compact('petList','user'));
    }

    //ユーザー会員情報編集ページへ
    public function edit()
    {
        //ログインしていなければログインページへ
        $userId = session('user_id');
        if($userId == null){
            $errorMessages = 'セッションが切れました';
            return view('user.login', compact('errorMessages'));
        }

        //ペットが登録されていなければ新規作成ページへ
        $petDataExists = Pet::FindFirstPet($userId);
        if($petDataExists == false)
        {
            return redirect()->route('user.pet.create');
        }

        //ペットの名前、健康状態記入の有無を取得
        $petNames = Pet::FindPetNames($userId);
        $today = date("Y/m/d");
        foreach ($petNames as $index => $petDeta)
        {
            $healthDataExists = PetsHealth::FindTodayHealth($petDeta['pet_id'], $today);
            if($healthDataExists == null)
            {
                $petNames[$index]['message'] = '今日の状態を記入しましょう';
            }
        }
        $petList = $petNames;

        //ユーザー情報の取得
        $user = User::find($userId);

        // 会員情報編集ページへ
        return view('user.edit', compact('petList','user'));
    }
}