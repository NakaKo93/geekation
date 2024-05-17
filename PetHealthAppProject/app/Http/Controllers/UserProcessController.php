<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Chat;
use App\Models\Pet;
use App\Models\PetsHealth;
use App\Models\Veterinarian;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserProcessController extends Controller
{
    /**
     * 新規作成処理
     * 
     * @param Request $request ユーザー情報
     * @return 
     */
    public function createProcess(Request $request)
    {
        //バリデーション
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ],[
            'name.required' => '名前を入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスの形式が正しくありません',
            'email.unique' => 'このメールアドレスは既に使用されています',
            'password.required' => 'パスワードを入力してください',
            'password.min' => 'パスワードは6文字以上である必要があります',
        ]);

        //バリデーション失敗
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        // ユーザー登録
        $validated = $validator->validated();
        $userId= User::UserCreate($validated);

        //登録失敗
        if($userId == false){
            return redirect()->back()
                            ->with('errorMessages', '登録に失敗しました');
        }
        
        // セッションにuser_idを保存
        session(['user_id' => $userId]);

        // 新規ペット追加ページへ
        return redirect()->route('user.pet.create');
    }

    /**
     * ログイン処理
     * 
     * @param Request $request ユーザー情報
     * @return 
     */
    public function loginProcess(Request $request)
    {
        //バリデーション
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ],[
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスの形式が正しくありません',
            'password.required' => 'パスワードを入力してください',
            'password.min' => 'パスワードは6文字以上である必要があります'
        ]);

        //バリデーション失敗
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        // ログイン処理
        $validated = $validator->validated();
        $loginUserId = User::LogIn($validated);

        //ログイン失敗
        if($loginUserId == false){
            return redirect()->back()->with('errorMessages', 'ログインに失敗しました');
        }

        // セッションにuser_idを保存
        session(['user_id' => $loginUserId]);

        //ペットデータを取得
        $FirstPetId = Pet::FindFirstPet($loginUserId);

        if($FirstPetId == false){
            //ペットを登録していない場合はペット新規作成ページへ
            return redirect()->route('user.pet.create');
        }else{
            //ペットを登録していない場合はペットホームページへ
            return redirect()->route('user.home', ['petId' => $FirstPetId]);
        }
    }

    /**
     * 会員情報編集処理
     * 
     * @param Request $request ユーザー情報
     * @return 
     */
    public function editProcess(Request $request)
    {
        //ログインしていなければログインページへ
        $userId = session('user_id');
        if($userId == null){
        $errorMessages = 'セッションが切れました';
            return view('user.login', compact('errorMessages'));
        }

        //バリデーション
        $user = User::find($userId);
        $password = $user->password;
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|max:100',
            'email' => 'nullable|email|unique',
            'password' => [
                'nullable',
                function ($attribute, $value, $fail) use ($password) {
                    if (!Hash::check($value, $password)) {
                        return $fail('現在のパスワードが正しくありません');
                    }
                },
            ],
            'newPassword' => 'nullable|min:6'
        ],[
            'email.email' => 'メールアドレスの形式が正しくありません',
            'email.unique' => 'このメールアドレスは既に使用されています',
            'newPassword.min' => 'パスワードは6文字以上である必要があります'
        ]);

        //バリデーション失敗
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        // ユーザー情報更新
        $validated = $validator->validated();
        $updateUser = User::UserUpdate($userId, $validated);

        //登録失敗
        if($updateUser == false){
            $errorMessages = '登録に失敗しました';
            return view('user.create', compact('errorMessages'));
        }

        //ホームに表示用のデータを取得
        $FirstPetId = Pet::FindFirstPet($userId);

        if($validated['newPassword']){
            //パスワードを更新した場合は、ログインページへ
            return redirect()->route('user.login');
        }else{
            //パスワードを更新した場合は、ホームページへ
            return redirect()->route('user.home', ['petId' => $FirstPetId]);
        }
    }

    /**
     * メッセージ送信処理
     * 
     * @param Request $request ユーザー情報
     * @param string $petId ペットID
     * @param string $vetId 獣医師ID
     * @return 
     */
    public function sendProcess(Request $request, $vetId, $petId)
    {
        //ログインしていなければログインページへ
        $userId = session('user_id');
        if($userId == null){
            $errorMessages = 'セッションが切れました';
            return view('user.login', compact('errorMessages'));
        }

        //獣医師データが入力されていない場合エラーを出す
        if ($vetId == null){
            return redirect()->back()
                            ->with('errorMessages', '獣医師データの取得に失敗しました');
        }

        //バリデーション
        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:1000'
        ],[
            'message.required' => 'メッセージを入力してください',
            'message.string' => 'メッセージは文字で入力してください',
            'message.max' => 'メッセージは1000文字以内で入力してください'
        ]);

        //バリデーション失敗
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }
        
        //登録
        $chatData = $validator->validated();
        $fromVet = false;
        $sendChat = Chat::ChatCreate($userId, $vetId, $chatData, $fromVet);

        //登録失敗
        if($sendChat == false)
        {
            return redirect()->back()->with('errorMessages', 'チャットの作成に失敗しました');
        }

        //ペットの情報を取得
        if($petId == null)
        {
            $petId = Pet::FindFirstPet($userId);
        }

        // ホームへ
        return redirect()->route('user.home', ['petId' => $petId]);
    }

    //有料会員処理
    public function premiumProcess()
    {
        //ログインしていなければログインページへ
        $userId = session('user_id');
        if($userId == null){
        $errorMessages = 'セッションが切れました';
        return view('user.login', compact('errorMessages'));
        }

        //登録処理
        $StatusUpdate = User::StatusUpdate($userId);

        //登録失敗
        if($StatusUpdate == false)
        {
            return redirect()->back()
                            ->with('errorMessages', '登録に失敗しました');
        }

        //ホームに表示用のデータを取得
        $FirstPetId = Pet::FindFirstPet($userId);
        if($FirstPetId == false)
        {
            // 登録されてなければペット新規登録ページへ
            return redirect()->route('user.pet.create');
        }

        // ホームへ
        return redirect()->route('user.home', ['petId' => $FirstPetId]);
    }

    //ユーザー情報消去処理
    public function deleteProcess()
    {
        //ログインしていなければログインページへ
        $userId = session('user_id');
        if($userId == null){
        $errorMessages = 'セッションが切れました';
        return view('user.login', compact('errorMessages'));
        }

        //消去処理
        $delete = User::UserDelete($userId);

        //消去失敗
        if($delete == false)
        {
            return redirect()->back()
                            ->with('errorMessages', '消去に失敗しました');
        }

        //セッションを削除
        session()->forget('user_id');

        //ログインページへ
        return redirect()->route('user.login');
    }

    //ログアウト処理
    public function logoutProcess()
    {
        //セッションを削除
        session()->forget('user_id');

        //ログインページへ
        return redirect()->route('user.login');
    }
}
