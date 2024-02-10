<?php
/* Smarty version 4.3.4, created on 2024-02-09 03:18:09
  from 'C:\xampp\htdocs\mvc_app\Views\contacts\confirm.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_65c51ae190c6e5_74654513',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '347acbc6e1c50e45d51e1617ab7fc150c97212a8' => 
    array (
      0 => 'C:\\xampp\\htdocs\\mvc_app\\Views\\contacts\\confirm.tpl',
      1 => 1707416268,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/header.tpl' => 1,
    'file:layout/footer.tpl' => 1,
  ),
),false)) {
function content_65c51ae190c6e5_74654513 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
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
        <?php $_smarty_tpl->_subTemplateRender("file:layout/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
            <div class="form-wrapper">
                <h1>お問い合わせ内容確認</h1>
                <div class="form-item">
                    <p class="label-text">氏名</p>
                    <p class="data-text"><?php echo $_smarty_tpl->tpl_vars['data']->value['name'];?>
</p>
                </div>

                <div class="form-item">
                    <p class="label-text">ふりがな</p>
                    <p class="data-text"><?php echo $_smarty_tpl->tpl_vars['data']->value['kana'];?>
</p>
                </div>

                <div class="form-item">
                    <p class="label-text">電話番号</p>
                    <p class="data-text"><?php echo $_smarty_tpl->tpl_vars['data']->value['tel'];?>
</p>
                </div>

                <div class="form-item">
                    <p class="label-text">メールアドレス</p>
                    <p class="data-text"><?php echo $_smarty_tpl->tpl_vars['data']->value['email'];?>
</p>
                </div>

                <div class="form-item">
                    <p class="label-text">内容</p>
                    <p class="data-text"><?php echo $_smarty_tpl->tpl_vars['data']->value['body'];?>
</p>
                </div>

                <div class="container text-center">
                    <div class="row edit-button">
                        <div class="col">
                            <a href="/contacts/form" class="button mt-4">キャンセル</a>
                        </div>
                        <div class="col">
                            <a href="/contacts/create" class="button mt-4">送信</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php $_smarty_tpl->_subTemplateRender("file:layout/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    </div>
</body><?php }
}
