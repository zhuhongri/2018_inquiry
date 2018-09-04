<?php
require_once('init.php');
// 入力データを取得
$input_data = [];
if (isset($_SESSION['input'])) {
    $input_data = $_SESSION['input'];
    unset($_SESSION['input']);
}
// errorデータを取得
$error = [];
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}
//var_dump($input_data, $error);
// XSS対策
function h($s) {
    return htmlspecialchars($s, ENT_QUOTES);
}
// CSRFの埋め込み
// TODO: tokenの寿命、タブで開いたらNG
$csrf_token = get_csrf_token();
$_SESSION['csrf'] = $csrf_token;
// smartyへの値渡し
$smarty_obj->assign('input_data', $input_data);
$smarty_obj->assign('error', $error);
$smarty_obj->assign('csrf_token', $csrf_token);
// 出力
$tmp_filename = 'form.tpl';
require_once('./fin.php');