<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    // モデルと関連しているテーブル
    protected $table = 'chats';

    //  テーブルの主キー
    protected $primaryKey = 'chats_id';

    //マスアサインメントのブラックリストの指定
    protected $guarded = [
        'chats_id',
        'created_at',
        'updated_at'
    ];

    // チャットが属するユーザーのリレーションを定義
    public function UserRelation()
    {
        return $this->belongsTo(User::class);
    }

    // チャットが属する獣医師のリレーションを定義
    public function VetRelation()
    {
        return $this->belongsTo(Veterinarian::class);
    }

   /**
     * メッセージデータを取得
     * 
     * @param string $userId ユーザーID
     * @return Model 見つかったメッセージデータを返却する
     */
    public function FindMessage($userId)
    {
        if($userId == null){
            return false;
        }

        $chatsList = Chat::where('user_id', $userId)->get();

        if ($chatsList->isEmpty()) {
            return false;
        } else {
            return $chatsList;
        }
    }

   /**
     * メッセージデータを保存
     * 
     * @param string $userId ユーザーID
     * @param string $vetId 獣医師ID
     * @param string $required メッセージデータ
     * @param bool $fromVet どちらから送られたものか
     * @return Model 獣医師データを返却する
     */
    public function ChatCreate($userId, $vetId, $required, $fromVet)
    {
        if (is_null($userId) || is_null($vetId) || !isset($required['message']) || is_null($fromVet)) {
            return 0;
        }
        
        try {
            $chat = Chat::create([
                'user_id' => $userId,
                'vet_id' => $vetId,
                'message' => $required['message'],
                'from_vet' => $fromVet
            ]);
        } catch (QueryException | PDOException | Exception $e) {
            return 1;
        }
        
        $chatid = $chat->chats_id;
        return $chatid;
    }
}
