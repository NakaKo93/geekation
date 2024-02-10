<?php
require_once ROOT_PATH.'Controllers/Controller.php';
require_once ROOT_PATH . 'Controllers/UserController.php';

require_once ROOT_PATH . 'Models/Contacts.php';

class ContactsController extends Controller
{
    public function form(){
        $UserController = new UserController;
        $auth = $UserController->getAuth();

        $errorMessages = $_SESSION['errorMessages'];
        $post = $_SESSION['post'];
        $_SESSION['errorMessages'] = [];
        $_SESSION['post'] = [];
        $Contacts = new Contacts;
        $result = $Contacts->getContactsAll();
        $this->view('contacts/form', ['dataAll' => $result, 'errorMessages' => $errorMessages, 'data' => $post, 'auth' => $auth]);
    }

    public function confirm(){
        $UserController = new UserController;
        $auth = $UserController->getAuth();

        $errorMessages = [];

        if (empty($_POST['name'])) {
            $errorMessages['name'] = '氏名を入力してください。';
        }elseif( 10 < mb_strlen($_POST['name']) ) {
            $errorMessages['name'] = "氏名は10文字以内で入力してください。";
        }

        if (empty($_POST['kana'])) {
            $errorMessages['kana'] = 'ふりがなを入力してください。';
        }elseif( 10 < mb_strlen($_POST['kana']) ) {
            $errorMessages['kana'] = "ふりがなは10文字以内で入力してください。";
        }

        $tel = str_replace('-', '', $_POST['tel']);
        if (empty($tel)) {
            $errorMessages['tel'] = '電話番号を入力してください。';
        }elseif (!preg_match( '/^[0-9]+$/', $tel)) {
            $errorMessages['tel'] = '電話番号を正しく入力してください。';
        }

        if (empty($_POST['email'])) {
            $errorMessages['email'] = 'メールアドレスを入力してください。';
        }elseif( !preg_match( '/^[0-9a-z_.\/?-]+@([0-9a-z-]+\.)+[0-9a-z-]+$/', $_POST['email']) ) {
            $error[] = "メールアドレスを正しく入力してください。";
        }

        if (empty($_POST['body'])) {
            $errorMessages['body'] = 'お問い合わせ内容を入力してください';
        }

        if(!empty($errorMessages)){
            // バリデーション失敗
            $_SESSION['errorMessages'] = $errorMessages;
            $_SESSION['post'] = $_POST;
            header('Location: /contacts/form');
        }else{
            $_SESSION['post'] = $_POST;
            $this->view('contacts/confirm', ['data' => $_POST, 'auth' => $auth]);
        }
    }

    public function create(){
        $post = $_SESSION['post'];
        $_SESSION['post'] = [];
        $tel = str_replace('-', '', $post['tel']);
        $created_at = date("Y-m-d H:i:s");
        $contacts = new Contacts;
        $result = $contacts->create(
            $post['name'],
            $post['kana'],
            $tel,
            $post['email'],
            $post['body'],
            $created_at
        );
        header('Location: /contacts/form');
    }

    public function edit(){
        $UserController = new UserController;
        $auth = $UserController->getAuth();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //formから問い合わせを選択した場合
            $_SESSION['id'] = $_POST['id'];
            $Contacts = new Contacts;
            $result = $Contacts->getContacts($_SESSION['id']);
            $this->view('contacts/edit', ['data' => $result, 'auth' => $auth]);
        } else {
            // updateでバリデーション失敗していた場合
            $errorMessages = $_SESSION['errorMessages'];
            $post = $_SESSION['post'];
            $_SESSION['errorMessages'] = [];
            $_SESSION['post'] = [];
            $this->view('contacts/edit', ['errorMessages' => $errorMessages, 'data' => $post, 'auth' => $auth]);
        }
    }

    public function update(){
        $errorMessages = [];

        if (empty($_POST['name'])) {
            $errorMessages['name'] = '氏名を入力してください。';
        }elseif( 10 < mb_strlen($_POST['name']) ) {
            $errorMessages['name'] = "氏名は10文字以内で入力してください。";
        }

        if (empty($_POST['kana'])) {
            $errorMessages['kana'] = 'ふりがなを入力してください。';
        }elseif( 10 < mb_strlen($_POST['kana']) ) {
            $errorMessages['kana'] = "ふりがなは10文字以内で入力してください。";
        }

        $tel = str_replace('-', '', $_POST['tel']);
        if (empty($tel)) {
            $errorMessages['tel'] = '電話番号を入力してください。';
        }elseif (!preg_match( '/^[0-9]+$/', $tel)) {
            $errorMessages['tel'] = '電話番号を正しく入力してください。';
        }

        if (empty($_POST['email'])) {
            $errorMessages['email'] = 'メールアドレスを入力してください。';
        }elseif( !preg_match( '/^[0-9a-z_.\/?-]+@([0-9a-z-]+\.)+[0-9a-z-]+$/', $_POST['email']) ) {
            $error[] = "メールアドレスを正しく入力してください。";
        }

        if (empty($_POST['body'])) {
            $errorMessages['body'] = 'お問い合わせ内容を入力してください';
        }

        $created_at = date("Y-m-d H:i:s");

        if(!empty($errorMessages)){
            // バリデーション失敗
            $_SESSION['errorMessages'] = $errorMessages;
            $_SESSION['post'] = $_POST;
            header('Location: /contacts/edit');
        }else{
            // 更新処理
            $contacts = new Contacts;
            $result = $contacts->update(
                $_SESSION['id'],
                $_POST['name'],
                $_POST['kana'],
                $tel,
                $_POST['email'],
                $_POST['body'],
                $created_at
            );
            
            $_SESSION['id'] = [];
            header('Location: /contacts/form');
        }
    }

    public function delete(){
        $contacts = new Contacts;
        $contacts->deleteContacts($_POST['id']);
        header('Location: /contacts/form');
    }
}