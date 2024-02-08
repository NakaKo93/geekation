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
            <h1>お問い合わせ</h1>
            <form action="/contacts/confirm" method="post">

                <div class="form-item">
                    <label for="name">氏名</label>
                    <input type="text" name="name" placeholder="テスト太郎" value="{$post['name']|default:$data['name']}">
                    <p class="error-text">{$errorMessages['name']|default:''}</p>
                </div>

                <div class="form-item">
                    <label for="kana">ふりがな</label>
                    <input type="text" name="kana" placeholder="てすとたろう" value="{$post['kana']|default:$data['kana']}">
                    <p class="error-text">{$errorMessages['kana']|default:''}</p>
                </div>

                <div class="form-item">
                    <label for="tel">電話番号</label>
                    <input type="tel" name="tel" placeholder="03-1234-5678" value="{$post['tel']|default:$data['tel']}">
                    <p class="error-text">{$errorMessages['tel']|default:''}</p>
                </div>

                <div class="form-item">
                    <label for="email">メールアドレス</label>
                    <input type="email" name="email" placeholder="exemple@cin-group.co.jp" value="{$post['email']|default:$data['email']}">
                    <p class="error-text">{$errorMessages['email']|default:''}</p>
                </div>

                <div class="form-item">
                    <label for="body">お問い合わせ内容</label>
                    <input type="body" name="body" placeholder="" value="{$post['body']|default:$data['body']}">
                    <p class="error-text">{$errorMessages['body']|default:''}</p>
                </div>

                <div class="edit-button">
                    <input type="submit" class="button" value="送信">
                </div>
            </form>
        </div>
        <div class="mx-auto mb-5 p-2 bg-white" style="width: 900px;">
            <table class="table mb-0">
                <thead class="table-light text-center">
                    <tr>
                        <th scope="col">氏名</th>
                        <th scope="col">フリガナ</th>
                        <th scope="col">電話番号</th>
                        <th scope="col">メールアドレス</th>
                        <th scope="col">問い合わせ内容</th>
                        <th scope="col">編集</th>
                        <th scope="col">消去</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider text-center">
                    {foreach $dataAll as $user}
                        <tr>
                            <td scope="row">{$user->name|default:''}</td>
                            <td>{$user->kana|default:''}</td>
                            <td>{$user->tel|default:''}</td>
                            <td>{$user->email|default:''}</td>
                            <td>{$user->body|default:''}</td>
                            <form action="/contacts/edit" method="post">
                                <td>
                                    <input type="hidden" name="id" placeholder="" value="{$user->id}">
                                    <input type="submit" class="button btn btn-light m-0 px-auto" value="編集">
                                </td>
                            </form>
                            <form action="/contacts/delete" method="post">
                                <td>
                                    <input type="hidden" name="id" placeholder="" value="{$user->id}">
                                    <input type="submit" class="button btn btn-light m-0 px-auto" value="消去" onclick="return confirm('本当に消去しますか?')">
                                </td>
                            </form>
                        </tr>
                    {/foreach}
                </tbody>
            </table>
        </div>
        {include file="layout/footer.tpl"}
    </div>
</div>
</body>