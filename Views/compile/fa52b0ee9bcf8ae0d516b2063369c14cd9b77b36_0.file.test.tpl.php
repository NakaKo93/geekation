<?php
/* Smarty version 4.3.4, created on 2024-02-08 21:58:40
  from 'C:\xampp\htdocs\mvc_app\Views\contacts\test.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_65c4d000b7e9f3_42473650',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fa52b0ee9bcf8ae0d516b2063369c14cd9b77b36' => 
    array (
      0 => 'C:\\xampp\\htdocs\\mvc_app\\Views\\contacts\\test.tpl',
      1 => 1707397101,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/header.tpl' => 1,
  ),
),false)) {
function content_65c4d000b7e9f3_42473650 (Smarty_Internal_Template $_smarty_tpl) {
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
    <?php $_smarty_tpl->_subTemplateRender("file:layout/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    <p>test</p>
    <ul>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value, 'item');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>
            <li><?php echo $_smarty_tpl->tpl_vars['item']->value;?>
</li>
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    </ul>
    <P>-------------------------------------------------------</P>
    <P><?php echo (($tmp = $_smarty_tpl->tpl_vars['data']->value->name ?? null)===null||$tmp==='' ? $_smarty_tpl->tpl_vars['data']->value['kana'] ?? null : $tmp);?>
</P>
    <P><?php echo (($tmp = $_smarty_tpl->tpl_vars['data']->value->name ?? null)===null||$tmp==='' ? $_smarty_tpl->tpl_vars['data']->value['tel'] ?? null : $tmp);?>
</P>
    <P>-------------------------------------------------------</P>
    <p><?php echo (($tmp = $_smarty_tpl->tpl_vars['errorMessages']->value['name'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
</p>
</body><?php }
}
