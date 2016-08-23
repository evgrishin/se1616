<?php /* Smarty version Smarty-3.1.19, created on 2016-08-23 16:43:00
         compiled from "T:\home\stamp-expert.ru\www\admin145cmtsg7\themes\default\template\helpers\modules_list\modal.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1556257bc44d4eea255-07160117%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a9396f9b5bac5d5436800dc55ff717cdbecdd35a' => 
    array (
      0 => 'T:\\home\\stamp-expert.ru\\www\\admin145cmtsg7\\themes\\default\\template\\helpers\\modules_list\\modal.tpl',
      1 => 1471950113,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1556257bc44d4eea255-07160117',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_57bc44d4ef41f6_63781200',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57bc44d4ef41f6_63781200')) {function content_57bc44d4ef41f6_63781200($_smarty_tpl) {?><div class="modal fade" id="modules_list_container">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title"><?php echo smartyTranslate(array('s'=>'Recommended Modules and Services'),$_smarty_tpl);?>
</h3>
			</div>
			<div class="modal-body">
				<div id="modules_list_container_tab_modal" style="display:none;"></div>
				<div id="modules_list_loader"><i class="icon-refresh icon-spin"></i></div>
			</div>
		</div>
	</div>
</div>
<?php }} ?>
