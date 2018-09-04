<?php  // admin_list.php
//
require_once('init_admin_auth.php');
//var_dump($_GET);
// DBへの接続
$dbh = db_connect($config);
/*
 * 検索条件の確認
 */
$where = [];
$where_data = [];
$find_uri_params = [];
// 「名前」の検索
$find_name = (string)@$_GET['find_name'];
//var_dump($find_name);
if ('' !== $find_name) {
    // SQLのWHERE句作成用
    $where[] = 'name LIKE :find_name';
    $where_data[':find_name'] = "{$find_name}%"; // XXX エスケープはしない
    // URIのパラメタ作成用
    $find_uri_params['find_name'] = $find_name;
    // テンプレートへのアサイン
    $smarty_obj->assign('find_name', $find_name);
}
// 「連絡先」の検索
$find_address = (string)@$_GET['find_address'];
//var_dump($find_address);
if ('' !== $find_address) {
    // SQLのWHERE句作成用
    $where[] = 'address LIKE :find_address';
    $where_data[':find_address'] = "{$find_address}%"; // XXX エスケープはしない
    // URIのパラメタ作成用
    $find_uri_params['find_address'] = $find_address;
    // テンプレートへのアサイン
    $smarty_obj->assign('find_address', $find_address);
}
// 作成日(問い合わせがあった日付)の検索
// XXX fromとtoが逆転してもチェックしない
$find_created_from = (string)@$_GET['find_created_from'];
//$find_created_from = 'November 8th, 2016';
if ('' !== $find_created_from) {
    // 文字列をパースしてエポック秒を把握する
    $t = strtotime($find_created_from);
    if (false !== $t) {
        // 日付フォーマットをいったん整形する
        $find_created_from = date('Y-m-d', $t);
        // SQLのWHERE句作成用
        $where[] = 'created_at >= :find_created_from';
        $where_data[':find_created_from'] = "{$find_created_from} 00:00:00";
        // URIのパラメタ作成用
        $find_uri_params['find_created_from'] = $find_created_from;
        // テンプレートへのアサイン
        $smarty_obj->assign('find_created_from', $find_created_from);
    }
}
// XXX fromとtoが逆転してもチェックしない
$find_created_to = (string)@$_GET['find_created_to'];
if ('' !== $find_created_to) {
    // 文字列をパースしてエポック秒を把握する
    $t = strtotime($find_created_to);
    if (false !== $t) {
        // 日付フォーマットをいったん整形する
        $find_created_to = date('Y-m-d', $t);
        // SQLのWHERE句作成用
        $where[] = 'created_at <= :find_created_to';
        $where_data[':find_created_to'] = "{$find_created_to} 23:59:59";
        // URIのパラメタ作成用
        $find_uri_params['find_created_to'] = $find_created_to;
        // テンプレートへのアサイン
        $smarty_obj->assign('find_created_to', $find_created_to);
    }
}
// 「「返信していない」もの」の検索
$find_no_response = (string)@$_GET['find_no_response'];
if ('' !== $find_no_response) {
    // SQLのWHERE句作成用
    $where[] = 'response_body IS NULL';
    // URIのパラメタ作成用
    $find_uri_params['find_no_response'] = $find_no_response;
    // テンプレートへのアサイン
    $smarty_obj->assign('find_no_response', true);
}
/*
 * sort
 */
// sort用ホワイトリスト
$sort_list = [
    'id'         => 'id',
    'id_d'       => 'id DESC',
    'name'       => 'name',
    'name_d'     => 'name DESC',
    'created'    => 'created_at',
    'created_d'  => 'created_at DESC',
    'response'   => 'response_at',
    'response_d' => 'response_at DESC',
];
// ソート内容の把握
$sort_wk = (string)@$_GET['sort'];
$smarty_obj->assign('sort', $sort_wk);
if (isset($sort_list[$sort_wk])) {
    $sort = $sort_list[$sort_wk];
} else {
    $sort = 'created_at DESC';
}
// 検索条件の保存
$smarty_obj->assign('find_query', http_build_query($find_uri_params));
// プリペアドステートメントの作成
$sql = 'SELECT * FROM inquiry';
if ([] !== $where) {
    $sql .= ' WHERE ' . implode(' AND ', $where);
}
$sql .= ' ORDER BY ' . $sort .' LIMIT 0, 20;';
$pre = $dbh->prepare($sql);
// 値をバインド
foreach($where_data  as  $k => $v) {
    $pre->bindValue($k, $v); // XXX 全部stringなので第三引数は色々省略
}
// SQLの実行
$r = $pre->execute();
//データを取得
$data = $pre->fetchAll();
$smarty_obj->assign('data', $data);
// 出力
$tmp_filename = 'admin_list.tpl';
require_once('./fin.php');