<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Casteria</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
<div class="p-4 container-field form-orange">
    <div class="row justify-content-center">
        <div class="col-lg-6 mx-auto col-md-8">
            <h2 class="mb-4">ログイン</h2>
            <form action="/user/certification" method="post" class="bg-white p-3 rounded mb-5">
                <p class="error-text">{$errorMessages['auth']|default:''}</p>
                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input type="email" class="form-control" name="email" placeholder="exemple@cin-group.co.jp" value="{$post['email']|default:''}">
                    <p class="error-text">{$errorMessages['email']|default:''}</p>
                </div>

                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input type="password" class="form-control" name="password" placeholder="password" value="{$post['password']|default:''}">
                    <p class="error-text">{$errorMessages['password']|default:''}</p>
                </div>

                <div class="button-group">
                    <button class="btn bg-warning my-2">ログイン</button>
                </div>
            </form>
        </div>
    </div>
    <div>
        <div class="row justify-content-md-center text-center">
            <div class="col-lg-6 mx-auto col-md-8">
                <div class="bg-white p-3 rounded mb-5">
                    <div class="m-1">
                        <a href="/user/sign-up">登録がお済みでない方</a>
                    </div>
                    <div class="m-1">
                        <a href="#">パスワードをお忘れの方</a>
                    </div>
                    <div class="m-1">
                        <a href="/">トップページへ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</body>