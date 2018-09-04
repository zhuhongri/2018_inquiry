<?php  

require_once('init.php');

// エラーなら表示する
if (true === @$_SESSION['admin_login_error']) {
    unset($_SESSION['admin_login_error']);
    $smarty_obj->assign('error', true);
}

// 出力
$tmp_filename = 'admin_index.tpl';
require_once('./fin.php');