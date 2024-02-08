<?php
require_once(ROOT_PATH . 'Models/Db.php');

class Contacts extends Db
{
    public function __construct($dbh = null)
    {
        parent::__construct($dbh);
        $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * お問い合わせ登録処理を行う
     * 
     * @param string $name 氏名
     * @param string $kana ふりがな
     * @param string $tel 電話番号
     * @param string $email メールアドレス
     * @param string $body お問い合わせ内容
     * @param string $created_at 送信日時
     * @return false|string 'ユーザーID' または メールアドレスが重複している場合はfalseを返却
     */
    public function create(string $name, string $kana, string $tel, string $email, string $body, string $created_at)
    {
        try{
            $this->dbh->beginTransaction();
            $query = 'INSERT INTO contacts (name, kana, tel, email, body, created_at) VALUES (:name, :kana, :tel, :email, :body, :created_at)';
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':kana', $kana);
            $stmt->bindParam(':tel', $tel);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':body', $body);
            $stmt->bindParam(':created_at', $created_at);
            $stmt->execute();

            // トランザクションを完了することでデータの書き込みを確定させる
            $this->dbh->commit();

        } catch (PDOException $e) {
            // 不具合があった場合トランザクションをロールバックして変更をなかったコトにする。
            $this->dbh->rollBack();
            echo "登録失敗: " . $e->getMessage() . "\n";
            exit();
        }
    }

    /**
    * お問い合わせ登録を行ったデータをすべて取得して返却する
    *
    * @return array object型で取得したお問い合わせのすべてのデータを返却する
    */
    public function getContactsAll(): array
    {
        try{
            $query = 'SELECT * FROM contacts';
            $stmt = $this->dbh->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ); 
        } catch (PDOException $e) {
            echo "取得エラー: ". $e->getMessage(). "\n";
            exit();
        }
    }

    /**
    * お問い合わせ登録を行ったデータを取得して返却する
    *
    * @param string $id ユーザーID
    * @return stdClass object型で取得したお問い合わせのデータを返却する
    */
    public function getContacts(string $id): stdClass
    {
        try{
            $query = 'SELECT * FROM contacts WHERE id = :id';
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ); 
        } catch (PDOException $e) {
            echo "取得エラー: ". $e->getMessage(). "\n";
            exit();
        }
    }

    /**
    * お問い合わせ登録を行ったデータを更新する
    * @param string $id 更新対象のユーザーID
    * @param string $name 氏名
    * @param string $kana ふりがな
    * @param string $tel 電話番号
    * @param string $email メールアドレス
    * @param string $body お問い合わせ内容
    * @param string $created_at 送信日時
    */
    public function update(string $id, string $name, string $kana, string $tel, string $email, string $body, string $created_at) {
        try{
            $this->dbh->beginTransaction();

            $query =  'UPDATE contacts SET name = :name, kana = :kana, tel = :tel, email = :email, body = :body, created_at = :created_at';
            $query .= ' WHERE id = :id';
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':kana', $kana);
            $stmt->bindParam(':tel', $tel);
            $stmt->bindParam(':email', $email);
           $stmt->bindParam(':body', $body);
            $stmt->bindParam(':created_at', $created_at);
            $stmt->execute();
            // トランザクションを完了することでデータの書き込みを確定させる
            $this->dbh->commit();
        }catch (PDOException $e) {
            // 不具合があった場合トランザクションをロールバックして変更をなかったコトにする。
            $this->dbh->rollBack();
            echo "変更失敗: " . $e->getMessage() . "\n";
            exit();
        }
    }

    /**
    * ユーザーIDに対応するユーザーのデータをテーブルから削除する
    * @param string $id ユーザーID
    * @return void
    */
    public function deleteContacts(string $id) {
        try{
            $this->dbh->beginTransaction();
            $query = 'DELETE FROM contacts WHERE id = :id';
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            // トランザクションを完了することでデータの書き込みを確定させる
            $this->dbh->commit();
            return;
        } catch (PDOException $e) {
            // 不具合があった場合トランザクションをロールバックして変更をなかったコトにする。
            $this->dbh->rollBack();
            echo "消去失敗: " . $e->getMessage() . "\n";
            exit();
        }
    }
}