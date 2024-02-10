<?php
require_once ROOT_PATH.'Controllers/Controller.php';

require_once ROOT_PATH . 'Models/User.php';

class UserController extends Controller
{
    public function create()
    {
        $errorMessages = [];

        if (empty($_POST['name'])) {
            $errorMessages['name'] = '氏名を入力してください。';
        }

        if (empty($_POST['kana'])) {
            $errorMessages['kana'] = 'ふりがなを入力してください。';
        }

        if (empty($_POST['email'])) {
            $errorMessages['email'] = 'メールアドレスを入力してください。';
        }

        if (empty($_POST['password'])) {
            $errorMessages['password'] = 'パスワードを入力してください';
        }

        if ($_POST['password'] !== $_POST['password-confirmation']) {
            $errorMessages['password-confirmation'] = '確認用パスワードが正しくありません。';
        }

        if (!empty($errorMessages)) {
            // バリデーション失敗
            $_SESSION['errorMessages'] = $errorMessages;
            $_SESSION['post'] = $_POST;
            header('Location: /user/sign-up');
        } else {
            //登録処理
            $user = new User;
            $result = $user->create(
                $_POST['name'],
                $_POST['kana'],
                $_POST['email'],
                $_POST['password']
            );

            if (is_numeric($result)) {
                $_SESSION['auth'] = $result;

                $this->view('user/create-complete');
            } else {
                $errorMessages['email'] = 'メールアドレスが既に使用されています。';
                $_SESSION['errorMessages'] = $errorMessages;
                $_SESSION['post'] = $_POST;
                header('Location: /user/signup');
            }
        }
    }

    public function logIn(){
        if(is_numeric($this->getAuth())){
            // ログイン中の場合はトップページへリダイレクト
            header('Location: /');
            exit();
        }
        $errorMessages = $_SESSION['errorMessages'] ?? [];
        $post = $_SESSION['post'] ?? [];
        $_SESSION['errorMessages'] = [];
        $_SESSION['post'] = [];
        $this->view('user/login');
    }
    
    public function signUp(){
        if(is_numeric($this->getAuth())){
            // ログイン中の場合はトップページへリダイレクト
            header('Location: /');
            exit();
        }
        $errorMessages = $_SESSION['errorMessages'] ?? [];
        $post = $_SESSION['post'] ?? [];
        $_SESSION['errorMessages'] = [];
        $_SESSION['post'] = [];
        $this->view('user/signup', ['errorMessages' => $errorMessages, 'post' => $post]);
    }

    public function logOut(){
        $_SESSION['auth'] = false;
        header('Location: /');
        exit();
    }

    /**
    * ログイン状態を取得する
    * @return string|false ログイン状態の場合はuserId  未ログイン状態の場合はfalseを返却する
    */
    public function getAuth(){
        return $_SESSION['auth'] ?? false;
    }

    public function certification(){
        $errorMessages = [];
        if(empty($_POST['email'])){
            $errorMessages['email'] = 'メールアドレスを入力してください。';
        }
    
        if(empty($_POST['password'])){
            $errorMessages['password'] = 'パスワードを入力してください';
        }
    
        if(!empty($errorMessages)){
            // バリデーション失敗
                    $_SESSION['errorMessages'] = $errorMessages;
                    $_SESSION['post'] = $_POST;
                    header('Location: /user/log-in');
        }else{
            //認証処理
            $user = new User;
            $result = $user->certification(
                $_POST['email'],
                $_POST['password']
            );
    
            if(is_array($result)){
                $_SESSION['auth'] = $result['id'];
                header("Location: /");
                exit();
            }else{
                $errorMessages['auth'] = 'メールアドレスまたはパスワードが誤っています。';
                $this->view('user/login', ['post' => $_POST, 'errorMessages' => $errorMessages]);
            }
        }
    }

    public function myPage(){
        $userId = $this->getAuth();
        if($userId === false){
            header('Location: /');
            exit();
        }

        $user = new User;
        $result = $user->getMyPage($userId);
        $this->view('user/mypage', ['data' => $result, 'auth' => $userId]);
    }

    public function edit(){
        $userId = $this->getAuth();
        if($userId === false){
            header('Location: /');
            exit();
        }

        $user = new User;
        $result = $user->getMyPage($userId);
        $errorMessages = $_SESSION['errorMessages'] ?? [];
        $post = $_SESSION['post'] ?? [];
        $_SESSION['errorMessages'] = [];
        $_SESSION['post'] = [];
        if(empty($errorMessages))
        {
            $this->view('user/edit', ['data' => $result, 'auth' => $userId]);
        }else{
            $this->view('user/edit', ['data' => $post,   'auth' => $userId, 'errorMessages' => $errorMessages]);
        }
    }

    public function update(){
        $errorMessages = [];

        $userId = $this->getAuth();
        if($userId === false){
            // 未ログインの場合はトップページへリダイレクト
            header('Location: /');
            exit();
        }

        if(empty($_POST['name'])){
            $errorMessages['name'] = '氏名を入力してください。';
        }

        if(empty($_POST['kana'])){
            $errorMessages['kana'] = 'ふりがなを入力してください。';
        }

        if(empty($_POST['email'])){
            $errorMessages['email'] = 'メールアドレスを入力してください。';
        }

        if(empty($_POST['password'])) {
            // passwordが空の場合はpasswordを更新しないためバリエーションをチェックしない
        }else{
            if($_POST['password'] !== $_POST['password-confirmation']){
                $errorMessages['password-confirmation'] = '確認用パスワードが正しくありません。';
            }
        }

        if(!empty($errorMessages)){
            // バリデーション失敗
            $_SESSION['errorMessages'] = $errorMessages;;
            $_SESSION['post'] = $_POST;
            header('Location: /user/edit');
        }else{
            // 更新処理
            $user = new User;
            $result = $user->update(
                $userId,
                $_POST['name'],
                $_POST['kana'],
                $_POST['email'],
                $_POST['password']
            );
            
            if($result === true){
                header('Location: /user/my-page');
                exit();
            }else{
                $errorMessages['email'] = 'メールアドレスが既に使用されています。';
                $_SESSION['errorMessages'] = $errorMessages;
                $_SESSION['post'] = $_POST;
                header('Location: /user/edit');
            }
        }
    }

    public function delete(){
        $userId = $_SESSION['auth'] ?? false;
        if($userId === false){
            header('Location: /');
            exit();
        }
        $user = new User;
        $user->deleteUserAccount($userId);
        $_SESSION['auth'] = false;
        header('Location: /');
        exit();
    }
}