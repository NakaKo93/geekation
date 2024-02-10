<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Casteria</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/login.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>

<body>
<div class="main">
    <div class="container-field" >
        {include file="layout/header.tpl"}
            <div class="form-wrapper">
                <h1>ユーザー情報</h1>
                <div class="form-item">
                    <p class="label-text">氏名</p>
                    <p class="data-text">{$data->name}</p>
                </div>

                <div class="form-item">
                    <p class="label-text">ふりがな</p>
                    <p class="data-text">{$data->kana}</p>
                </div>

                <div class="form-item">
                    <p class="label-text">メールアドレス</p>
                    <p class="data-text">{$data->email}</p>
                </div>

                <div class="form-item">
                    <p class="label-text">パスワード</p>
                    <p class="data-text">{$data->password}</p>
                </div>

                <div class="edit-button">
                    <a href="/user/edit" class="button">プロフィールの編集</a>
                </div>
            </div>
        {include file="layout/footer.tpl"}
    </div>
</body>