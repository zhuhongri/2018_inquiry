<?php  
require_once('init_admin_auth.php');
// IDの取得
$id = (string)@$_GET['id'];
//var_dump($id);
// DBハンドルの取得
$dbh = db_connect($config);
// DBから情報を取得
// プリペアドステートメントを作成
$sql = 'SELECT * FROM inquiry WHERE id = :id;';
$pre = $dbh->prepare($sql);
// 値をバインド
$pre->bindValue(':id', $id);
// SQLを実行
$r = $pre->execute();
// データを取得
$data = $pre->fetch();
if (false === $data) {
    // データがなかったら一覧にすっ飛ばす
    header('Location: ./admin_list.php');
    exit;
}
//var_dump($data);
// 指定されたIDの問い合わせ内容を出力
$smarty_obj->assign('detail', $data);
// CSRFの埋め込み
// TODO: tokenの寿命、タブで開いたらNG
$csrf_token = get_csrf_token();
$_SESSION['admin_csrf'] = $csrf_token;
$smarty_obj->assign('csrf_token', $csrf_token);
// 出力
$tmp_filename = 'admin_detail.tpl';
require_once('./fin.php');
