<?php /* Smarty version Smarty-3.1.19, created on 2016-08-23 16:42:58
         compiled from "T:\home\stamp-expert.ru\www\admin145cmtsg7\themes\default\template\helpers\list\list_action_edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1120557bc44d2bafd76-77719326%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2d1617add31d0bfbe8b981f74ad18a1ccfd85488' => 
    array (
      0 => 'T:\\home\\stamp-expert.ru\\www\\admin145cmtsg7\\themes\\default\\template\\helpers\\list\\list_action_edit.tpl',
      1 => 1471950112,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1120557bc44d2bafd76-77719326',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'href' => 0,
    'action' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_57bc44d2bffaa9_20680357',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57bc44d2bffaa9_20680357')) {function content_57bc44d2bffaa9_20680357($_smarty_tpl) {?>
<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['href']->value, ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="edit">
	<i class="icon-pencil"></i> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>

</a><?php }} ?>
