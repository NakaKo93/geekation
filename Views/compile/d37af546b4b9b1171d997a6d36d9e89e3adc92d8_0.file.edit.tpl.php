<?php
/* Smarty version 4.3.4, created on 2024-02-09 03:52:14
  from 'C:\xampp\htdocs\mvc_app\Views\contacts\edit.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_65c522de4f0918_82321648',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd37af546b4b9b1171d997a6d36d9e89e3adc92d8' => 
    array (
      0 => 'C:\\xampp\\htdocs\\mvc_app\\Views\\contacts\\edit.tpl',
      1 => 1707416237,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/header.tpl' => 1,
    'file:layout/footer.tpl' => 1,
  ),
),false)) {
function content_65c522de4f0918_82321648 (Smarty_Internal_Template $_smarty_tpl) {
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
        <div class="container-field">
            <?php $_smarty_tpl->_subTemplateRender("file:layout/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
            <div class="form-wrapper">
                <h1>お問い合わせ内容編集</h1>
                <form action="/contacts/update" method="post">
    
                    <div class="form-item">
                        <label for="name">氏名</label>
                        <input type="text" name="name" placeholder="テスト太郎" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['data']->value->name ?? null)===null||$tmp==='' ? $_smarty_tpl->tpl_vars['data']->value['name'] ?? null : $tmp);?>
">
                        <p class="error-text"><?php echo (($tmp = $_smarty_tpl->tpl_vars['errorMessages']->value['name'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
</p>
                    </div>
    
                    <div class="form-item">
                        <label for="kana">ふりがな</label>
                        <input type="text" name="kana" placeholder="てすとたろう" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['data']->value->kana ?? null)===null||$tmp==='' ? $_smarty_tpl->tpl_vars['data']->value['kana'] ?? null : $tmp);?>
">
                        <p class="error-text"><?php echo (($tmp = $_smarty_tpl->tpl_vars['errorMessages']->value['kana'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
</p>
                    </div>
    
                    <div class="form-item">
                        <label for="tel">電話番号</label>
                        <input type="tel" name="tel" placeholder="03-1234-5678" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['data']->value->tel ?? null)===null||$tmp==='' ? $_smarty_tpl->tpl_vars['data']->value['tel'] ?? null : $tmp);?>
">
                        <p class="error-text"><?php echo (($tmp = $_smarty_tpl->tpl_vars['errorMessages']->value['tel'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
</p>
                    </div>
    
                    <div class="form-item">
                        <label for="email">メールアドレス</label>
                        <input type="email" name="email" placeholder="exemple@cin-group.co.jp" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['data']->value->email ?? null)===null||$tmp==='' ? $_smarty_tpl->tpl_vars['data']->value['email'] ?? null : $tmp);?>
">
                        <p class="error-text"><?php echo (($tmp = $_smarty_tpl->tpl_vars['errorMessages']->value['email'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
</p>
                    </div>
    
                    <div class="form-item">
                        <label for="body">お問い合わせ内容</label>
                        <input type="body" name="body" placeholder="お問い合わせ内容" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['data']->value->body ?? null)===null||$tmp==='' ? $_smarty_tpl->tpl_vars['data']->value['body'] ?? null : $tmp);?>
">
                        <p class="error-text"><?php echo (($tmp = $_smarty_tpl->tpl_vars['errorMessages']->value['body'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
</p>
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
            <?php $_smarty_tpl->_subTemplateRender("file:layout/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
        </div>
    </div>
</body><?php }
}
