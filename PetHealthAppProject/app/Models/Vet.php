<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\Model;

class Vet extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    // モデルと関連しているテーブル
    protected $table = 'veterinarians';

    //  テーブルの主キー
    protected $primaryKey = 'vet_id';

    //マスアサインメントのブラックリストの指定
    protected $guarded = [
        'vet_id',
        'created_at',
        'updated_at'
    ];
    
    // 獣医師が所有するチャットのリレーションを定義
    public function ChatRelation()
    {
        return $this->hasMany(Chat::class, 'chats_id');
    }

    /**
     * 獣医師データの新規作成
     * 
     * @param string $request 獣医師データ
     * @return Model 登録した獣医師データを返却する
     */
    public function VetCreate($request)
    {
        if($request == null){
            return false;
        }

        try {
            $newVet = Vet::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'one_word' => $request['one_word']
            ]);
        } catch (QueryException | PDOException | Exception $e) {
            return false;
        }

        if($newVet){
            return $newVet->vet_id;
        }else{
            return false;
        }
    }

    /**
     * ログイン
     * 
     * @param string $request 獣医師データ
     * @return string|false 見つかった獣医師IDを返却する
     */
    public function LogIn($request)
    {
        if($request == null){
            return false;
        }

        $vet = Vet::where('email', $request['email'])->first();
        if ($vet && Hash::check($request['password'], $vet->password)) 
        {
            return $vet->vet_id;
        }

        return false;
    }

    /**
     * 獣医師データの更新
     * 
     * @param string $vetId 獣医師ID
     * @param string $request 獣医師データ
     * @return string|false 更新操作のID or 成功可否
     */
    public function VetUpdate($vetId, $request)
    {
        if($vetId == null || $request == null){
            return false;
        }

        $vet = Vet::find($vetId);

        if($request['name']){
            $vet->name = $request['name'];
        }
        if($request['email']){
            $vet->email = $request['email'];
        }
        if ($request['newPassword']) {
            $vet->password = Hash::make($request['newPassword']);
        }
        if ($request['one_word']) {
            $vet->one_word = $request['one_word'];
        }

        try {
            $saveResult = $vet->save();
        } catch (QueryException | PDOException | Exception $e) {
            return false;
        }
        
        if($saveResult){
            return $vet->vet_id;
        }else{
            return false;
        }
    }
    
    /**
     * 獣医師データの消去
     * 
     * @param string $vetID 獣医師ID
     * @return bool 消去操作の成功可否
     */
    public function VetDelete($vetId)
    {
        if($vetId == null){
            return false;
        }

        $deleteResult = Vet::find($vetId)->delete();
        return $deleteResult; 
    }
}
