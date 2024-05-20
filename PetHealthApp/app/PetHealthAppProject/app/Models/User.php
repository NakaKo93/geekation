<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    // モデルと関連しているテーブル
    protected $table = 'users';

    //  テーブルの主キー
    protected $primaryKey = 'user_id';

    //マスアサインメントのブラックリストの指定
    protected $guarded = [
        'user_id',
        'created_at',
        'updated_at',
        'status'
    ];

    // ユーザーが所有するペットのリレーションを定義
    public function PetRelation()
    {
        return $this->hasMany(Pet::class, 'user_id');
    }

    // ユーザーが所有するチャットのリレーションを定義
    public function ChatRelation()
    {
        return $this->hasMany(Chat::class, 'chats_id');
    }
    
    /**
     * 新規作成
     * 
     * @param string $request ユーザーデータ
     * @return string|false 更新操作のID or 成功可否
     */
    public function UserCreate($request)
    {
        if($request == null){
            return false;
        }

        try {
            $newUser = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);
        } catch (QueryException | PDOException | Exception $e) {
            return false;
        }

        if($newUser){
            return $newUser->user_id;
        }else{
            return false;
        }
    }

    /**
     * ログイン
     * 
     * @param string $request ユーザー情報
     * @return string|false 見つかったユーザーIDを返却する
     */
    public function LogIn($request)
    {
        if($request == null){
            return false;
        }

        $user = User::where('email', $request['email'])->first();
        if ($user && Hash::check($request['password'], $user->password)) 
        {
            return $user->user_id;
        }else
        {
            return false;
        }
    }

    /**
     * 会員のステータスを取得
     * 
     * @param string $userId ユーザーID
     * @return bool|null 見つかったステータスを返却する or 見つから無ければnull
     */
    public function FindStatus($userId)
    {
        if($userId == null){
            return false;
        }

        $status = User::find($userId)->status;
        if($status){
            return $status;
        }else{
            return null;
        }
    }

    /**
     * ユーザーデータの更新
     * 
     * @param string $userId ユーザーID
     * @param string $request ユーザーデータ
     * @return string|false 更新操作のID or 成功可否
     */
    public function UserUpdate($userId, $request)
    {
        if($userId == null || $request == null){
            return false;
        }

        $user = User::find($userId);
        if (!$user) {
            return false;
        }

        if($request->name){
            $user->name = $request['name'];
        }
        if($request->email){
            $user->email = $request['email'];
        }
        if ($request->newPassword) {
            $user->password = Hash::make($request['newPassword']);
        }

        try {
            $saveResult = $user->save();
        } catch (QueryException | PDOException | Exception $e) {
            return false;
        }
        
        if($saveResult){
            return $user->user_id;
        }else{
            return false;
        }
    }

    /**
     * 会員ステータスの更新
     * 
     * @param string $userId ユーザーID
     * @return bool 更新操作の成功可否
     */
    public function StatusUpdate($userId)
    {
        if($userId == null){
            return false;
        }

        $status = true;

        $user = User::find($userId);
        $user = User::find($userId);
        if (!$user) {
            return false;
        }
        
        $user->status = $status;
        try {
            $saveResult = $user->save(); 
        } catch (QueryException | PDOException | Exception $e) {
            return false;
        }
        return $saveResult; 
    }

    /**
     * ユーザーデータの消去
     * 
     * @param string $userID ユーザーID
     * @return bool 消去操作の成功可否
     */
    public function UserDelete($userId)
    {
        if($userId == null){
            return false;
        }

        $deleteResult = User::find($userId)->delete(); 
        return $deleteResult; 
    }
}
