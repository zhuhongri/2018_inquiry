<?php  // admin_update.php
//
require_once('init_admin_auth.php');
// 返信内容を取得
$body = (string)@$_POST['response_body'];
//var_dump($body);
// IDを取得
$id = (string)@$_POST['id'];
//var_dump($id);
// CSRF対策
// tokenの取得
$token = (string)@$_POST['csrf'];
if ('' === $token) {
    $error_flg['csrf_error'] = 1;
}
// tokenの比較
if ($_SESSION['admin_csrf'] !== $token) { // XXX hash_equals
    $error_flg['csrf_error'] = 1;
}
unset($_SESSION['admin_csrf']); // 一回使い切り
// XXX TODO エラーメッセージ
if (1 == @$error_flg['csrf_error']) {
    header('Location: ./admin_detail.php?id=' . rawurlencode($id));
    exit;
}
// DBハンドルの取得
$dbh = db_connect($config);
// 返信内容をDBに登録
// プリペアドステートメントを作成
$sql = 'UPDATE inquiry 
           SET response_name = :response_name
             , response_body = :response_body
             , response_at = :response_at
         WHERE id = :id;';
$pre = $dbh->prepare($sql);
// 値をバインド
$pre->bindValue(':response_name', $_SESSION['admin_auth']['id']);
$pre->bindValue(':response_body', $body);
$pre->bindValue(':response_at', date('Y-m-d H:i:s'));
$pre->bindValue(':id', $id);
// SQLを実行
$r = $pre->execute();
// Locationで詳細画面に戻す
header('Location: ./admin_detail.php?id=' . rawurlencode($id));