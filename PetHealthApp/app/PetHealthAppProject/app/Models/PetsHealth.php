<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\Model;

class PetsHealth extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    // モデルと関連しているテーブル
    protected $table = 'petsHealth';

    //  テーブルの主キー
    protected $primaryKey = 'pethealth_id';

    //マスアサインメントのブラックリストの指定
    protected $guarded = [
        'pethealth_id',
        'created_at',
        'updated_at'
    ];

    // ペット健康情報が属するペットのリレーションを定義
    public function PetRelation()
    {
        return $this->belongsTo(Pet::class);
    }

    /**
     * その日の健康データの記入可否チェック
     * 
     * @param string $petId ペットID
     * @param string $date 日付
     * @return Model ペット健康データの記入がしていなければfalse、なければnull
     */
    public function CheckTodayHealth($petId, $date)
    {
        if($petId == null || $date == null){
            return false;
        }

        $pet = Pet::find($petId);
        if (!$pet) {
            return false;
        }

        $todayHealth = $pet->HealthRelation()->whereDate('date', $date)->first();
        if($todayHealth == null){
            return false;
        }else{
            return true;   
        }
    }

    /**
     * その日の健康データを取得
     * 
     * @param string $petId ペットID
     * @param string $date 日付
     * @return Model ペット健康データ
     */
    public function FindTodayHealth($petId, $date)
    {
        if($petId == null || $date == null){
            return false;
        }

        $pet = Pet::find($petId);
        if (!$pet) {
            return false;
        }
        
        $todayHealth = $pet->HealthRelation()->whereDate('date', $date)->first();
        if($todayHealth == null){
            return false;
        }else{
            return $todayHealth;
        }
    }

    /**
     * ペット健康情報の新規作成
     * 
     * @param int $petId ペットID
     * @param array $request ペット健康情報のデータ
     * @return Model 新規作成されたペット健康情報のインスタンス
     */
    public static function PetHealthCreate($petId, $request)
    {
        if($petId == null || $request == null){
            return false;
        }

        $pet = Pet::find($petId);
        if (!$pet) {
            return false;
        }

        $newPetHealth = $pet->HealthRelation()->create($request);

        if($newPetHealth){
            return $newPetHealth->pethealth_id;
        }else{
            return false;
        }
    }

    /**
     * ペット健康情報データの更新
     * 
     * @param int $petId ペットID
     * @param string $date 日付
     * @param string $request ペット健康情報データ
     * @return bool 更新操作の成功可否
     */
    public function PetHealthUpdate($petId, $date, $request)
    {
        if($petId == null || $date == null || $request == null){
            return false;
        }

        $pet = Pet::find($petId);
        if (!$pet) {
            return false;
        }

        $todayHealth = $pet->HealthRelation()->whereDate('date', $date)->first();
        if (!$todayHealth) {
            return false;
        }

        $saveResult = $todayHealth->fill($request)->save();

        return $saveResult;     
    }
}
