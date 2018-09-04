<?php // input.php
require_once( __DIR__ . '/init.php');
// 入力値の取得
/*
// いろいろな「入力値の取得方法」
$name = (string)@$_POST['name'];
$name = @$_POST['name'] ?? ''; // PHP7以降
$name = (string)filter_input(INPUT_POST, 'name');
if (true === isset($_POST['name'])) {
    $name = $_POST['name'];
} else {
    $name = '';
}
*/
/*
// これで「ダメ」とは言わないが……
$name = @$_POST['name'] ?? '';
$address = @$_POST['address'] ?? '';
$body = @$_POST['body'] ?? '';
*/
//
$params = ['name', 'address', 'body'];
$input_data = []; // 入力値保存用
foreach($params as $p) {
    $input_data[$p] = @$_POST[$p] ?? '';
}
//var_dump($input_data);
// validate
$error_flg = [];
// 「address と body」は必須入力
if ('' === $input_data['address']) {
    // エラー
    $error_flg['address_empty'] = 1;
}
if ('' === $input_data['body']) {
    // エラー
    $error_flg['body_empty'] = 1;
}
// CSRFチェック
// tokenの取得
$token = (string)@$_POST['csrf'];
if ('' === $token) {
    $error_flg['csrf_error'] = 1;
}
// tokenの比較
if ($_SESSION['csrf'] !== $token) {
    $error_flg['csrf_error'] = 1;
}
unset($_SESSION['csrf']); // 一回使い切り
//
if ([] !== $error_flg) {
    // form.phpにデータを渡す
    $_SESSION['input'] = $input_data;
    $_SESSION['error'] = $error_flg;
    // エラーが発生してる！！
    header('Location: ./form.php');
    exit;
}
// DBへの接続
$dbh = db_connect($config);
/* DBへのINSERT */
// 準備された文(プリペアドステートメント)の作成
$sql = 'INSERT INTO inquiry(name, address, body, created_at)
               VALUES(:name, :address, :body, now());';
$pre = $dbh->prepare($sql);
//var_dump($pre); exit;
// プレースホルダへの値のバインド
$pre->bindValue(':name'   , $input_data['name'], PDO::PARAM_STR); // 正しい
$pre->bindValue(':address', $input_data['address']); // 文字列なら省略可
$pre->bindValue(':body'   , $input_data['body']);
// SQLの実行
$r = $pre->execute();
//var_dump( $dbh->errorInfo() );
//var_dump($r); exit;
//
header('Location: fin.html');