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
        <div class="container-field">
            {include file="layout/header.tpl"}
            <div class="form-wrapper">
                <h1>お問い合わせ内容編集</h1>
                <form action="/contacts/update" method="post">
    
                    <div class="form-item">
                        <label for="name">氏名</label>
                        <input type="text" name="name" placeholder="テスト太郎" value="{$data->name|default:$data['name']}">
                        <p class="error-text">{$errorMessages['name']|default:''}</p>
                    </div>
    
                    <div class="form-item">
                        <label for="kana">ふりがな</label>
                        <input type="text" name="kana" placeholder="てすとたろう" value="{$data->kana|default:$data['kana']}">
                        <p class="error-text">{$errorMessages['kana']|default:''}</p>
                    </div>
    
                    <div class="form-item">
                        <label for="tel">電話番号</label>
                        <input type="tel" name="tel" placeholder="03-1234-5678" value="{$data->tel|default:$data['tel']}">
                        <p class="error-text">{$errorMessages['tel']|default:''}</p>
                    </div>
    
                    <div class="form-item">
                        <label for="email">メールアドレス</label>
                        <input type="email" name="email" placeholder="exemple@cin-group.co.jp" value="{$data->email|default:$data['email']}">
                        <p class="error-text">{$errorMessages['email']|default:''}</p>
                    </div>
    
                    <div class="form-item">
                        <label for="body">お問い合わせ内容</label>
                        <input type="body" name="body" placeholder="お問い合わせ内容" value="{$data->body|default:$data['body']}">
                        <p class="error-text">{$errorMessages['body']|default:''}</p>
                    </div>

                    <div class="container text-center">
                        <div class="row edit-button">
                            <div class="col">
                                <input type="submit" class="button" value="更新する">
                            </div>
                            <div class="col">
                                <a href="/contacts/form" class="button">キャンセル</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            {include file="layout/footer.tpl"}
        </div>
    </div>
</body>