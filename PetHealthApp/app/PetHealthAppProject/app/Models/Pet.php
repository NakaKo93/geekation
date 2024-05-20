<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    
    // モデルと関連しているテーブル
    protected $table = 'pets';

    //  テーブルの主キー
    protected $primaryKey = 'pet_id';

    //マスアサインメントのブラックリストの指定
    protected $guarded = [
        'pet_id',
        'created_at',
        'updated_at'
    ];

    // ペットが属するユーザーのリレーションを定義
    public function UserRelation()
    {
        return $this->belongsTo(User::class);
    }

    // ペットが持つ健康データのリレーションを定義
    public function HealthRelation()
    {
        return $this->hasOne(petsHealth::class, 'pet_id');
    }

    /**
     * ペットに紐づいたユーザーデータを取得
     * 
     * @param string $userId ペットID
     * @return Model 見つかったペットのIDと名前を返却する
     */
    public function FindUser($petId)
    {
        if($petId == null){
            return false;
        }

        $pet = Pet::find($petId);
        if ($pet) {
            return $userId = $pet->user_id;
        } else {
            return $userId = false;
        }
    }

    /**
     * ユーザーに紐づいたペットの名前を取得
     * 
     * @param string $userId ユーザーID
     * @return Model 見つかったペットのIDと名前を返却する
     */
    public function FindPetNames($userId)
    {
        if($userId == null){
            return false;
        }

        $user = User::find($userId);
        if (!$user) {
            return false;
        }

        $petNames = $user->PetRelation()->get(['pet_id', 'name']);
        if (!$petNames) {
            return false;
        }

        return $petNames;
    }

    /**
     * ユーザーに紐づいた一つ目のペットデータを取得
     * 
     * @param string $userID ユーザー情報
     * @return string ペットのID
     */
    public function FindFirstPet($userId)
    {
        if($userId == null){
            return false;
        }

        $user = User::find($userId);
        if (!$user) {
            return false;
        }

        $petsId = $user->PetRelation()->get(['pet_id']);
        if($petsId->isEmpty()){
            return false;
        }
        
        return $petsId[0];
    }

    /**
     * ペットデータの新規作成
     * 
     * @param int $userId ユーザーID
     * @param request $request ペットのデータ
     * @return Model 新規作成されたペットのインスタンス
     */
    public static function PetCreate($userId, $request)
    {
        if($userId == null || $request == null){
            return false;
        }

        $user = User::find($userId);
        if (!$user) {
            return false;
        }

        try {
            $newPet = $user->PetRelation()->create($request);
        } catch (QueryException | PDOException | Exception $e) {
            return false;
        }

        if($newPet){
            return $newPet->pet_id;
        }else{
            return false;
        }
    }

    /**
     * ペットデータの更新
     * 
     * @param string $petId ペットID
     * @param string $request ペットデータ
     * @return bool 更新操作の成功可否
     */
    public function PetUpdate($petId, $request)
    {
        if($petId == null || $request == null){
            return false;
        }

        $pet = Pet::find($petId);
        try {
            $saveResult = $pet->fill($request)->save();
        } catch (QueryException | PDOException | Exception $e) {
            return false;
        }

        return $saveResult;
    }

    /**
     * ペットデータの消去
     * 
     * @param string $userID ペットID
     * @return bool 消去操作の成功可否
     */
    public function PetDelete($petId)
    {
        if($petId == null){
            return false;
        }

        $deleteResult = Pet::find($petId)->delete();
        return $deleteResult; 
    }

}
