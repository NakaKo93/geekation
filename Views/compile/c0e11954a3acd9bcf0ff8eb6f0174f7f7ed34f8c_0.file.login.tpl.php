<?php
/* Smarty version 4.3.4, created on 2023-11-17 21:29:44
  from 'C:\xampp\htdocs\mvc_app\Views\user\login.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_65575cb8048126_26861462',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c0e11954a3acd9bcf0ff8eb6f0174f7f7ed34f8c' => 
    array (
      0 => 'C:\\xampp\\htdocs\\mvc_app\\Views\\user\\login.tpl',
      1 => 1697020127,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_65575cb8048126_26861462 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
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
                <p class="error-text"><?php echo (($tmp = $_smarty_tpl->tpl_vars['errorMessages']->value['auth'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
</p>
                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input type="email" class="form-control" name="email" placeholder="exemple@cin-group.co.jp" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['post']->value['email'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
">
                    <p class="error-text"><?php echo (($tmp = $_smarty_tpl->tpl_vars['errorMessages']->value['email'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
</p>
                </div>

                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input type="password" class="form-control" name="password" placeholder="password" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['post']->value['password'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
">
                    <p class="error-text"><?php echo (($tmp = $_smarty_tpl->tpl_vars['errorMessages']->value['password'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
</p>
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
</body><?php }
}
