<?php
require_once(ROOT_PATH . 'Models/Db.php');

class User extends Db
{
    public function __construct($dbh = null)
    {
        parent::__construct($dbh);
        $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * メールアドレスが一意か判定後ユーザー登録処理を行ってユーザーIDを返却する
     * 
     * @param string $name 氏名
     * @param string $kana ふりがな
     * @param string $email メールアドレス
     * @param string $password パスワード
     * @return false|string 'ユーザーID' または メールアドレスが重複している場合はfalseを返却
     */
    public function create(string $name, string $kana, string $email, string $password)
    {
        try{
            // 重複アドレスの確認 (メールアドレスが一意のためすでに使用されていた場合はエラーとする)
            $query = 'SELECT COUNT(*) as count FROM users WHERE email = :email';
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_OBJ);

            if($result->count != 0){
                // メールアドレス検索の結果重複していた場合はfalseを返却
                return false;
            }
			
            // 重複がない場合は処理を続行
            $this->dbh->beginTransaction();
            $query = 'INSERT INTO users (name, kana, email, password) VALUES (:name, :kana, :email, :password)';
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':kana', $kana, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
						$hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $hash, PDO::PARAM_STR);
            $stmt->execute();

            $lastId = $this->dbh->lastInsertId();

            // トランザクションを完了することでデータの書き込みを確定させる
            $this->dbh->commit();

            return $lastId;
        } catch (PDOException $e) {
            // 不具合があった場合トランザクションをロールバックして変更をなかったコトにする。
            $this->dbh->rollBack();
            echo "登録失敗: " . $e->getMessage() . "\n";
            exit();
        }
    }

    public function certification(string $email, string $password){
        try{
            $query = 'SELECT id, password FROM users WHERE email = :email';
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (is_array($result) && count($result) === 1) {
                $result_password = $result[0]['password'];
                if (password_verify($password, $result_password)) {
                    return $result[0];
                }
                return false;
            } else {
                return false;
            }

        } catch (PDOException $e) {
            echo "認証エラー: " . $e->getMessage() . "\n";
            exit();
        }
    }

    /**
    * マイページ表示用のユーザーデータを取得して返却する
    *
    * @param string $id ユーザーID
    * @return stdClass object型で取得したユーザーのデータを返却する
    */
    public function getMyPage(string $id): stdClass
    {
        try{
            $query = 'SELECT * FROM users WHERE id = :id';
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo "認証エラー: ". $e->getMessage(). "\n";
            exit();
        }
    }

    /**
    * ユーザーの情報を更新する
    * @param string $id 更新対象のユーザーID
    * @param string $name 氏名
    * @param string $kana ふりがな
    * @param string $email メールアドレス
    * @param string|null $password パスワード
    * @return bool メールアドレス重複時は更新処理をせずfalseを返却する
    */
    public function update(string $id, string $name, string $kana, string $email, string $password = null): bool
    {
    try{
        // 重複アドレスの確認 (メールアドレスが一意のためすでに使用されていた場合はエラーとする)
        $query = 'SELECT COUNT(*) as count FROM users WHERE email = :email AND id <> :id';
        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);

        if($result->count == '0'){
            // 重複がない場合は処理を続行
            $this->dbh->beginTransaction();

            $query =  'UPDATE users SET name = :name, kana = :kana, email = :email';
            if(!empty($password)){
                $query .= ', password = :password';
            }
            $query .= ' WHERE id = :id';
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':kana', $kana);
            $stmt->bindParam(':email', $email);
            if(!empty($password)) {
								$hash = password_hash($password, PASSWORD_BCRYPT);
                $stmt->bindParam(':password', $hash);
            }
            $stmt->execute();
            // トランザクションを完了することでデータの書き込みを確定させる
            $this->dbh->commit();
            return true;
        }else{
        // メールアドレス検索の結果重複していた場合はfalseを返却
        return false;
    }
    
    } catch (PDOException $e) {
        // 不具合があった場合トランザクションをロールバックして変更をなかったコトにする。
        $this->dbh->rollBack();
        echo "登録失敗: " . $e->getMessage() . "\n";
        exit();
    }
    }

    /**
    * ユーザーIDに対応するユーザーのデータをテーブルから削除する
    * @param string $id ユーザーID
    * @return void
    */
    public function deleteUserAccount(string $id) {
        try{
            $this->dbh->beginTransaction();
            $query = 'DELETE FROM users WHERE id = :id';
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            // トランザクションを完了することでデータの書き込みを確定させる
            $this->dbh->commit();
            return;
        } catch (PDOException $e) {
            // 不具合があった場合トランザクションをロールバックして変更をなかったコトにする。
            $this->dbh->rollBack();
            echo "退会失敗: " . $e->getMessage() . "\n";
            exit();
        }
    }
}