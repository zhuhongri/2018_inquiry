<?php  // admin_login.php
//
require_once('init.php');
/* authentication */
// formからIDとパスワードを取得
$id = (string)@$_POST['id'];
$pw = (string)@$_POST['pw'];
// validate
if ( ('' === $id)||('' === $pw) ) {
    // validation error
    $_SESSION['admin_login_error'] = true;
    // indexに飛ばす
    header('Location: ./admin_index.php');
    exit;
}
/* DBから「hash化されたパスワード」を取得 */
// DBハンドルの取得
$dbh = db_connect($config);
// 準備された文(プリペアドステートメント)を作成
$sql = 'SELECT * FROM admin_users WHERE id = :id ;';
$pre = $dbh->prepare($sql);
// プレースホルダに値をbind
$pre->bindValue(':id', $id);
// SQLを発行
$r = $pre->execute();
$data = $pre->fetch();
//var_dump($data); exit;
// IDが存在しない場合の処理
if (false === $data) {
    // validation error
    $_SESSION['admin_login_error'] = true;
    // indexに飛ばす
    header('Location: ./admin_index.php');
    exit;
}
// パスワードを比較
if (false === password_verify($pw, $data['pass'])) {
    // validation error
    $_SESSION['admin_login_error'] = true;
    // indexに飛ばす
    header('Location: ./admin_index.php');
    exit;
}
/* ログイン成功 */
// 「ログインに成功した」データ(authorization)を保存しておく
session_regenerate_id(true); // セキュリティ対策
$_SESSION['admin_auth']['id'] = $id;
// TopPageに遷移
header('Location: ./admin_top.php');