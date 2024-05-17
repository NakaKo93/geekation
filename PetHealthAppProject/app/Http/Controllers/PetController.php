<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Chat;
use App\Models\Pet;
use App\Models\PetsHealth;
use App\Models\Veterinarian;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PetController extends Controller
{
    //ペット新規登録ページへ
    public function petCreate()
    {
        //セッションが切れていればログインページへ
        $userId = session('user_id');
        if($userId == null){
        $errorMessages = 'セッションが切れました';
        return view('user.login', compact('errorMessages'));
        }

        return view('user.pet.create');
    }

    //ペット追加登録ページへ
    public function petAdd()
    {
        //ログインしていなければログインページへ
        $userId = session('user_id');
        if($userId == null){
        $errorMessages = 'セッションが切れました';
        return view('user.login', compact('errorMessages'));
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

        // ペット追加登録ページへ
        return view('user.pet.add', compact('petList'));
    }

    /**
     * ペット情報編集ページへ
     * 
     * @param string $petId ペットID
     * @return 
     */
    public function petEdit($petId)
    {
        //ログインしていなければログインページへ
        $userId = session('user_id');
        if($userId == null){
            $errorMessages = 'セッションが切れました';
            return view('user.login', compact('errorMessages'));
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

        //ペットの詳細を取得
        if ($petId == null){
            //無ければログインページへ
            $errorMessages = 'セッションが切れました';
            return view('user.login', compact('errorMessages'));
        }
        $petDetails = Pet::find($petId);

        // ペット情報編集ページへ
        return view('user.pet.edit', compact('petDetails','petList'));
    }

    /**
     * ペット新規登録処理
     * 
     * @param Request $request ペット情報
     * @return 
     */
    public function petCreateProcess(Request $request)
    {
        //ログインしていなければログインページへ
        $userId = session('user_id');
        if($userId == null){
            $errorMessages = 'セッションが切れました';
            return view('user.login', compact('errorMessages'));
        }

        // リクエストデータを変更
        $data = $request->all();
        $data['gender'] = filter_var($request->input('gender'), FILTER_VALIDATE_BOOLEAN);

        //バリデーション
        $validator = Validator::make($data,[
        'photo_address' => 'nullable|url',
        'name' => [
            'required',
            'string',
            'max:100',
            Rule::unique('pets')->where(function ($query) use ($userId) {
                return $query->where('user_id', $userId);
            })
        ],
        'age' => 'required|integer|min:0',
        'gender' => 'required|boolean',
        'type' => 'required|string|max:100',
        'birth' => 'required|date',
        'adoption' => 'required|date',
        'memo' => 'nullable|string'
        ],[
        'photo_address.url' => '写真を保存できませんでした',
        'name.unique' => 'この名前のペットはすでに登録してあります',
        'name.required' => '名前を入力してください',
        'name.max' => '名前は最大100文字までです',
        'name.string' => '文字列で名前を入力してください',
        'age.required' => '年齢を入力してください',
        'age.integer' => '整数で年齢を入力してください',
        'age.min' => '年齢は0歳以上で入力してください',
        'gender.required' => '性別を入力してください',
        'type.required' => '種類を入力してください',
        'type.string' => '文字列で入力してください',
        'type.max' => '種類は最大100文字までです',
        'birth.required' => '誕生日を入力してください',
        'birth.date' => '有効な日付を入力してください',
        'adoption.required' => '向かい入れた日を入力してください',
        'adoption.date' => '有効な日付を入力してください',
        'memo.string' => '文字列で入力してください'
        ]);

        //バリデーション失敗
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        // ペット登録
        $validated = $validator->validated();
        $petId = Pet::PetCreate($userId,$validated);

        //登録失敗
        if($petId == false){
            return redirect()->back()
                            ->with('errorMessages', '登録に失敗しました');
        }
        
        // ホームへ
        return redirect()->route('user.home', ['petId' => $petId]);
    }

    /**
     * ペット情報編集処理
     * 
     * @param string $petId ペットID
     * @param Request $request ペット情報
     * @return 
     */
    public function petEditProcess($petId, Request $request)
    {
        //ログインしていなければログインページへ
        $userId = session('user_id');
        if($userId == null){
            $errorMessages = 'セッションが切れました';
            return view('user.login', compact('errorMessages'));
        }
        //ペットIDが入力されていない
        if ($petId == null){
            //無ければログインページへ
            $errorMessages = 'セッションが切れました';
            return view('user.login', compact('errorMessages'));
        }

        // リクエストデータを変更
        $data = $request->all();
        $data['gender'] = filter_var($request->input('gender'), FILTER_VALIDATE_BOOLEAN);

        //バリデーション
        $validator = Validator::make($data,[
        'photo_address' => 'nullable|url',
        'name' => [
            'required',
            'string',
            'max:100',
            Rule::unique('pets')->where(function ($query) use ($userId) {
                return $query->where('user_id', $userId);
            })
        ],
        'age' => 'required|integer|min:0',
        'gender' => 'required|boolean',
        'type' => 'required|string|max:100',
        'birth' => 'required|date',
        'adoption' => 'required|date',
        'memo' => 'nullable|string'
        ],[
        'photo_address.url' => '写真を保存できませんでした',
        'name.unique' => 'この名前のペットはすでに登録してあります',
        'name.required' => '名前を入力してください',
        'name.string' => '文字列で名前を入力してください',
        'name.max' => '名前は最大100文字までです',
        'age.required' => '年齢を入力してください',
        'age.integer' => '整数で年齢を入力してください',
        'age.min' => '年齢は0歳以上で入力してください',
        'gender.required' => '性別を入力してください',
        'type.required' => '種類を入力してください',
        'type.string' => '文字列で入力してください',
        'type.max' => '種類は最大100文字までです。',
        'birth.required' => '誕生日を入力してください',
        'birth.date' => '有効な日付を入力してください',
        'adoption.required' => '向かい入れた日を入力してください',
        'adoption.date' => '有効な日付を入力してください',
        'memo.string' => '文字列で入力してください'
        ]);

        //バリデーション失敗
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        // ペット登録
        $validated = $validator->validated();
        $editPet = Pet::PetUpdate($petId,$validated);

        //登録失敗
        if($editPet == null){
            return redirect()->back()
                            ->with('errorMessages', '登録に失敗しました');
        }

        // ホームへ
        return redirect()->route('user.home', ['petId' => $petId]);
    }

    /**
     * ペット情報消去
     * 
     * @param string $petId ペットID
     * @return 
     */
    public function petDeleteProcess($petId)
    {
        //ログインしていなければログインページへ
        $userId = session('user_id');
        if($userId == null){
            $errorMessages = 'セッションが切れました';
            return view('user.login', compact('errorMessages'));
        }
        //ペットIDが入力されていない
        if ($petId == null){
            //無ければログインページへ
            $errorMessages = 'セッションが切れました';
            return view('user.login', compact('errorMessages'));
        }

        //消去処理
        $delete = Pet::PetDelete($petId);

        //消去失敗
        if(!$delete){
            return redirect()->back()
                            ->with('errorMessages', '消去に失敗しました');
        }

        //残りのペットデータの有無の確認
        $petDataExists = Pet::FindFirstPet($userId);
        if($petDataExists == false)
        {
            // ペット新規登録ページへ
            return redirect()->route('user.pet.create');
        }else{
            $petId = $petDataExists;
            // ホームへ
            return redirect()->route('user.home', ['petId' => $petId]);
        }
    }

    /**
     * ペット健康登録処理
     * 
     * @param Request $request ペット情報
     * @param string $petId ペットID
     * @return 
     */
    public function petTodayHealthProcess(Request $request, $petId)
    {
        //ログインしていなければログインページへ
        $userId = session('user_id');
        if($userId == null){
            $errorMessages = 'セッションが切れました';
            return view('user.login', compact('errorMessages'));
        }
        //ペットIDが入力されていない
        if ($petId == null){
            //無ければログインページへ
            $errorMessages = 'セッションが切れました';
            return view('user.login', compact('errorMessages'));
        }

        //バリデーション
        $validator = Validator::make($request->all(),[
            'weight' => 'nullable|numeric|min:0|max:99.99',
            'breakfast_type' => 'nullable|string|max:100',
            'breakfast_amount' => 'nullable|numeric|min:0|max:99.99',
            'lunch_type' => 'nullable|string|max:100',
            'lunch_amount' => 'nullable|numeric|min:0|max:99.99',
            'dinner_type' => 'nullable|string|max:100',
            'dinner_amount' => 'nullable|numeric|min:0|max:99.99',
            'medicine' => 'nullable|string|max:100',
            'walk' => 'nullable|integer|min:0',
            'trimming' => 'nullable|boolean',
            'toilet' => 'nullable|integer|min:0',
            'memo' => 'nullable|string|max:1000'
        ],[
            'weight.numeric' => '体重は数値で入力してください',
            'weight.min' => '体重は0kg以上を指定してください',
            'weight.max' => '体重の最大値を超えています',
            'breakfast_type.string' => '朝食の種類は文字で入力してください',
            'breakfast_amount.numeric' => '朝食の量は数値で入力してください',
            'breakfast_amount.max' => '朝食の量の最大値を超えています',
            'lunch_type.string' => '昼食の種類は文字で入力してください',
            'lunch_amount.numeric' => '昼食の量は数値で入力してください',
            'lunch_amount.max' => '昼食の量の最大値を超えています',
            'dinner_type.string' => '夕食の種類は文字で入力してください',
            'dinner_amount.numeric' => '夕食の量は数値で入力してください',
            'dinner_amount.max' => '夕食の量の最大値を超えています',
            'medicine.string' => '薬の名称は文字で入力してください',
            'walk.integer' => '散歩時間は整数で入力してください',
            'trimming.boolean' => 'トリミングの入力が不正です',
            'toilet.integer' => 'トイレの回数は整数で入力してください',
            'memo.string' => 'メモは文字で入力してください',
            'memo.max' => 'メモは1000文字以内で入力してください'
        ]);

        //バリデーション失敗
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
            
        }

        //健康情報を登録
        $today = date("Y/m/d");
        $todayPetHealth = $validator->validated();
        $todayPetHealth['date'] = $today;
        $todayHealthExists = PetsHealth::CheckTodayHealth($petId, $today);
        if(!$todayHealthExists)
        {
            //新規作成
            $todayHealth = PetsHealth::PetHealthCreate($petId, $todayPetHealth);
        }else{
            //更新
            $todayHealth = PetsHealth::PetHealthUpdate($petId, $today, $todayPetHealth);
        }

        //登録失敗
        if($todayHealth == false){
            return redirect()->back()
                            ->with('errorMessages', '登録に失敗しました');
        }
        
        // ホームへ
        return redirect()->route('user.home', ['petId' => $petId]);
    }
}
