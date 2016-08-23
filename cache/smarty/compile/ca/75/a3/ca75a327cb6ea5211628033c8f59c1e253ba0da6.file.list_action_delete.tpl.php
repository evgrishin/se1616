<?php /* Smarty version Smarty-3.1.19, created on 2016-08-23 16:42:58
         compiled from "T:\home\stamp-expert.ru\www\admin145cmtsg7\themes\default\template\helpers\list\list_action_delete.tpl" */ ?>
<?php /*%%SmartyHeaderCode:314757bc44d2d1c7f1-78825455%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ca75a327cb6ea5211628033c8f59c1e253ba0da6' => 
    array (
      0 => 'T:\\home\\stamp-expert.ru\\www\\admin145cmtsg7\\themes\\default\\template\\helpers\\list\\list_action_delete.tpl',
      1 => 1471950113,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '314757bc44d2d1c7f1-78825455',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'href' => 0,
    'confirm' => 0,
    'action' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_57bc44d2da8427_40060374',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57bc44d2da8427_40060374')) {function content_57bc44d2da8427_40060374($_smarty_tpl) {?>
<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['href']->value, ENT_QUOTES, 'UTF-8', true);?>
"<?php if (isset($_smarty_tpl->tpl_vars['confirm']->value)) {?> onclick="if (confirm('<?php echo $_smarty_tpl->tpl_vars['confirm']->value;?>
')){return true;}else{event.stopPropagation(); event.preventDefault();};"<?php }?> title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="delete">
	<i class="icon-trash"></i> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>

</a><?php }} ?>
