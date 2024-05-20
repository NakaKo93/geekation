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

use Illuminate\Support\Facades\Hash;

class VetProcessController extends Controller
{
    /**
     * ログイン処理
     * 
     * @param Request $request 獣医師情報
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
        ]);

        //バリデーション失敗
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        // ログイン処理
        $validated = $validator->validated();
        $loginVetId = Vet::LogIn($validated);

        //ログイン失敗
        if($loginVetId == false){
            return redirect()->back()
                            ->with('errorMessages', 'ログインに失敗しました');
        }

        // セッションにvet_idを保存
        session(['vet_id' => $loginVetId]);

        //ホームに表示用のデータを取得
        $firstUser = User::first();
        $FirstUserId = $firstUser ? $firstUser->user_id : false;
        if($FirstUserId == false){
            //ユーザーが存在しない
            $errorMessages = 'ユーザーがいません';
            return view('vet.login', compact('errorMessages'));
        }
        $FirstPetId = Pet::FindFirstPet($FirstUserId);
        if($FirstPetId == false){
            //ペットIDが存在しない
            $errorMessages = 'ペットデータが存在しません';
            return view('vet.login', compact('errorMessages'));
        }

        // ホームへ
        return redirect()->route('vet.home', ['petId' => $FirstPetId]);
    }

    /**
     * 新規作成処理
     * 
     * @param Request $request 獣医師情報
     * @return 
     */
    public function createProcess(Request $request)
    {
        //バリデーション
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'email' => 'required|email|unique:veterinarians,email',
            'password' => 'required|min:6',
            'one_word' => 'nullable|max:500'
        ],[
            'name.required' => '名前を入力してください',
            'name.max' => '名前は100文字以内で入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスの形式が正しくありません',
            'email.unique' => 'このメールアドレスは既に使用されています',
            'password.required' => 'パスワードを入力してください',
            'password.min' => 'パスワードは6文字以上である必要があります',
            'one_word.max' => 'コメントは200文字以内で入力してください'
        ]);

        //バリデーション失敗
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        // ユーザー登録
        $validated = $validator->validated();
        $vetId= Vet::VetCreate($validated);

        //登録失敗
        if($vetId == false){
            return redirect()->back()
                            ->with('errorMessages', '登録に失敗しました');
        }
        
        // セッションにvet_idを保存
        session(['vet_id' => $vetId]);

        //ホームに表示用のデータを取得
        $firstUser = User::first();
        $FirstUserId = $firstUser ? $firstUser->user_id : false;
        if($FirstUserId == false){
            //ユーザーが存在しない
            $errorMessages = 'ユーザーがいません';
            return view('vet.login', compact('errorMessages'));
        }
        $FirstPetId = Pet::FindFirstPet($FirstUserId);
        if($FirstPetId == false){
            //ペットIDが存在しない
            $errorMessages = 'ペットデータが存在しません';
            return view('vet.login', compact('errorMessages'));
        }

        // ホームへ
        return redirect()->route('vet.home', ['petId' => $FirstPetId]);
    }

    /**
     * 会員情報編集処理
     * 
     * @param Request $request 獣医師情報
     * @return 
     */
    public function editProcess(Request $request)
    {
        //ログインしていなければログインページへ
        $vetId = session('vet_id');
        if($vetId == null){
            $errorMessages = 'セッションが切れました';
            return view('vet.login', compact('errorMessages'));
        }

        //バリデーション
        $vet = Vet::find($vetId);
        $password = $vet->password;
        //バリデーション
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|max:100',
            'email' => 'nullable|email|unique',
            'password' => [
                'nullable',
                function ($attribute, $value, $fail) use ($password) {
                    if (!Hash::check($value, $password)) {
                        return $fail('現在のパスワードが正しくありません。');
                    }
                },
            ],
            'newPassword' => 'nullable|min:6',
            'one_word' => 'nullable|max:500'
        ],[
            'email.unique' => 'このメールアドレスは既に使用されています',
            'email.email' => 'メールアドレスの形式が正しくありません',
            'newPassword.min' => 'パスワードは6文字以上である必要があります',
            'one_word.max' => 'コメントは200文字以内で入力してください'
        ]);

        //バリデーション失敗
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        // ユーザー情報更新
        $validated = $validator->validated();
        $updateVet = Vet::VetUpdate($vetId, $validated);

        //登録失敗
        if($updateVet == false){
            return redirect()->back()
                            ->with('errorMessages', '登録に失敗しました');
        }

        //ホームに表示用のデータを取得
        $firstUser = User::first();
        $FirstUserId = $firstUser ? $firstUser->user_id : null;
        if($FirstUserId == null){
            //ユーザーが存在しない
            $errorMessages = 'ユーザーがいません';
            return view('vet.login', compact('errorMessages'));
        }
        $FirstPetId = Pet::FindFirstPet($FirstUserId);
        if($FirstPetId == null){
            //ペットIDが存在しない
            $errorMessages = 'ペットデータが存在しません';
            return view('vet.login', compact('errorMessages'));
        }

        // ホームかログイン画面へ
        if($validated['newPassword']){
            //パスワードを更新した場合は、ログインページへ
            return redirect()->route('vet.login');
        }else{
            //パスワードを更新した場合は、ホームページへ
            return redirect()->route('vet.home', ['petId' => $FirstPetId]);
        }
    }

    /**
     * メッセージ送信処理
     * 
     * @param Request $request ユーザー情報
     * @param string $petId ペットID
     * @param string $userId ユーザーID
     * @return 
     */
    public function sendProcess(Request $request, $userId, $petId)
    {
        //ログインしていなければログインページへ
        $vetId = session('vet_id');
        if($vetId == null){
            $errorMessages = 'セッションが切れました';
            return view('vet.login', compact('errorMessages'));
        }

        //ユーザーデータが入力されていない場合エラーを出す
        if ($userId == null){
            return redirect()->back()
                            ->with('errorMessages', 'ユーザーデータの取得に失敗しました');
        }

        //バリデーション
        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:1000'
        ],[
            'message.required' => 'メッセージを入力してください',
            'memo.string' => 'メッセージは文字で入力してください',
            'memo.max' => 'メッセージは1000文字以内で入力してください'
        ]);

        //バリデーション失敗
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        //登録
        $chatData = $validator->validated();
        $fromVet = true;
        $sendChat = Chat::ChatCreate($userId, $vetId, $chatData, $fromVet);

        //登録失敗
        if($sendChat == false)
        {
            return redirect()->back()
                            ->with('errorMessages', '登録に失敗しました');
        }

        //ペットの情報を取得
        if($petId == null)
        {
            $petId = Pet::FindFirstPet($userId);
        }

        // ホームへ
        return redirect()->route('vet.home', ['petId' => $petId]);
    }

    //獣医師情報消去処理
    public function deleteProcess()
    {
        //ログインしていなければログインページへ
        $vetId = session('vet_id');
        if($vetId == null){
        $errorMessages = 'セッションが切れました';
        return view('vet.profile', compact('errorMessages'));
        }

        //消去処理
        $delete = Vet::VetDelete($vetId);

        //消去失敗
        if($delete == false)
        {
            return redirect()->back()
                            ->with('errorMessages', '消去に失敗しました');
        }

        // セッションを削除
        session()->forget('vet_id');

        // ログインページへ
        return redirect()->route('vet.login');
    }

    //ログアウト処理
    public function logoutProcess()
    {
        //セッションを削除
        session()->forget('vet_id');

        //ログインページへ
        return redirect()->route('vet.login');
    }
}