<?php
/* Smarty version 4.3.4, created on 2024-02-09 03:21:17
  from 'C:\xampp\htdocs\mvc_app\Views\contacts\form.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_65c51b9de50713_63183561',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '529c8702d16fd3713a0fb16fbae337f0906bd78b' => 
    array (
      0 => 'C:\\xampp\\htdocs\\mvc_app\\Views\\contacts\\form.tpl',
      1 => 1707416467,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/header.tpl' => 1,
    'file:layout/footer.tpl' => 1,
  ),
),false)) {
function content_65c51b9de50713_63183561 (Smarty_Internal_Template $_smarty_tpl) {
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
            <h1>お問い合わせ</h1>
            <form action="/contacts/confirm" method="post">

                <div class="form-item">
                    <label for="name">氏名</label>
                    <input type="text" name="name" placeholder="テスト太郎" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['post']->value['name'] ?? null)===null||$tmp==='' ? $_smarty_tpl->tpl_vars['data']->value['name'] ?? null : $tmp);?>
">
                    <p class="error-text"><?php echo (($tmp = $_smarty_tpl->tpl_vars['errorMessages']->value['name'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
</p>
                </div>

                <div class="form-item">
                    <label for="kana">ふりがな</label>
                    <input type="text" name="kana" placeholder="てすとたろう" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['post']->value['kana'] ?? null)===null||$tmp==='' ? $_smarty_tpl->tpl_vars['data']->value['kana'] ?? null : $tmp);?>
">
                    <p class="error-text"><?php echo (($tmp = $_smarty_tpl->tpl_vars['errorMessages']->value['kana'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
</p>
                </div>

                <div class="form-item">
                    <label for="tel">電話番号</label>
                    <input type="tel" name="tel" placeholder="03-1234-5678" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['post']->value['tel'] ?? null)===null||$tmp==='' ? $_smarty_tpl->tpl_vars['data']->value['tel'] ?? null : $tmp);?>
">
                    <p class="error-text"><?php echo (($tmp = $_smarty_tpl->tpl_vars['errorMessages']->value['tel'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
</p>
                </div>

                <div class="form-item">
                    <label for="email">メールアドレス</label>
                    <input type="email" name="email" placeholder="exemple@cin-group.co.jp" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['post']->value['email'] ?? null)===null||$tmp==='' ? $_smarty_tpl->tpl_vars['data']->value['email'] ?? null : $tmp);?>
">
                    <p class="error-text"><?php echo (($tmp = $_smarty_tpl->tpl_vars['errorMessages']->value['email'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
</p>
                </div>

                <div class="form-item">
                    <label for="body">お問い合わせ内容</label>
                    <input type="body" name="body" placeholder="" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['post']->value['body'] ?? null)===null||$tmp==='' ? $_smarty_tpl->tpl_vars['data']->value['body'] ?? null : $tmp);?>
">
                    <p class="error-text"><?php echo (($tmp = $_smarty_tpl->tpl_vars['errorMessages']->value['body'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
</p>
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
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['dataAll']->value, 'user');
$_smarty_tpl->tpl_vars['user']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['user']->value) {
$_smarty_tpl->tpl_vars['user']->do_else = false;
?>
                        <tr>
                            <td scope="row"><?php echo (($tmp = $_smarty_tpl->tpl_vars['user']->value->name ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
</td>
                            <td><?php echo (($tmp = $_smarty_tpl->tpl_vars['user']->value->kana ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
</td>
                            <td><?php echo (($tmp = $_smarty_tpl->tpl_vars['user']->value->tel ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
</td>
                            <td><?php echo (($tmp = $_smarty_tpl->tpl_vars['user']->value->email ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
</td>
                            <td><?php echo (($tmp = $_smarty_tpl->tpl_vars['user']->value->body ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
</td>
                            <form action="/contacts/edit" method="post">
                                <td>
                                    <input type="hidden" name="id" placeholder="" value="<?php echo $_smarty_tpl->tpl_vars['user']->value->id;?>
">
                                    <input type="submit" class="button btn btn-light m-0 px-auto" value="編集">
                                </td>
                            </form>
                            <form action="/contacts/delete" method="post">
                                <td>
                                    <input type="hidden" name="id" placeholder="" value="<?php echo $_smarty_tpl->tpl_vars['user']->value->id;?>
">
                                    <input type="submit" class="button btn btn-light m-0 px-auto" value="消去" onclick="return confirm('本当に消去しますか?')">
                                </td>
                            </form>
                        </tr>
                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                </tbody>
            </table>
        </div>
        <?php $_smarty_tpl->_subTemplateRender("file:layout/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    </div>
</div>
</body><?php }
}
