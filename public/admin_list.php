<?php  // admin_list.php
//
require_once('init_admin_auth.php');
//var_dump($_GET);
// DB�ւ̐ڑ�
$dbh = db_connect($config);
/*
 * ���������̊m�F
 */
$where = [];
$where_data = [];
$find_uri_params = [];
// �u���O�v�̌���
$find_name = (string)@$_GET['find_name'];
//var_dump($find_name);
if ('' !== $find_name) {
    // SQL��WHERE��쐬�p
    $where[] = 'name LIKE :find_name';
    $where_data[':find_name'] = "{$find_name}%"; // XXX �G�X�P�[�v�͂��Ȃ�
    // URI�̃p�����^�쐬�p
    $find_uri_params['find_name'] = $find_name;
    // �e���v���[�g�ւ̃A�T�C��
    $smarty_obj->assign('find_name', $find_name);
}
// �u�A����v�̌���
$find_address = (string)@$_GET['find_address'];
//var_dump($find_address);
if ('' !== $find_address) {
    // SQL��WHERE��쐬�p
    $where[] = 'address LIKE :find_address';
    $where_data[':find_address'] = "{$find_address}%"; // XXX �G�X�P�[�v�͂��Ȃ�
    // URI�̃p�����^�쐬�p
    $find_uri_params['find_address'] = $find_address;
    // �e���v���[�g�ւ̃A�T�C��
    $smarty_obj->assign('find_address', $find_address);
}
// �쐬��(�₢���킹�����������t)�̌���
// XXX from��to���t�]���Ă��`�F�b�N���Ȃ�
$find_created_from = (string)@$_GET['find_created_from'];
//$find_created_from = 'November 8th, 2016';
if ('' !== $find_created_from) {
    // ��������p�[�X���ăG�|�b�N�b��c������
    $t = strtotime($find_created_from);
    if (false !== $t) {
        // ���t�t�H�[�}�b�g���������񐮌`����
        $find_created_from = date('Y-m-d', $t);
        // SQL��WHERE��쐬�p
        $where[] = 'created_at >= :find_created_from';
        $where_data[':find_created_from'] = "{$find_created_from} 00:00:00";
        // URI�̃p�����^�쐬�p
        $find_uri_params['find_created_from'] = $find_created_from;
        // �e���v���[�g�ւ̃A�T�C��
        $smarty_obj->assign('find_created_from', $find_created_from);
    }
}
// XXX from��to���t�]���Ă��`�F�b�N���Ȃ�
$find_created_to = (string)@$_GET['find_created_to'];
if ('' !== $find_created_to) {
    // ��������p�[�X���ăG�|�b�N�b��c������
    $t = strtotime($find_created_to);
    if (false !== $t) {
        // ���t�t�H�[�}�b�g���������񐮌`����
        $find_created_to = date('Y-m-d', $t);
        // SQL��WHERE��쐬�p
        $where[] = 'created_at <= :find_created_to';
        $where_data[':find_created_to'] = "{$find_created_to} 23:59:59";
        // URI�̃p�����^�쐬�p
        $find_uri_params['find_created_to'] = $find_created_to;
        // �e���v���[�g�ւ̃A�T�C��
        $smarty_obj->assign('find_created_to', $find_created_to);
    }
}
// �u�u�ԐM���Ă��Ȃ��v���́v�̌���
$find_no_response = (string)@$_GET['find_no_response'];
if ('' !== $find_no_response) {
    // SQL��WHERE��쐬�p
    $where[] = 'response_body IS NULL';
    // URI�̃p�����^�쐬�p
    $find_uri_params['find_no_response'] = $find_no_response;
    // �e���v���[�g�ւ̃A�T�C��
    $smarty_obj->assign('find_no_response', true);
}
/*
 * sort
 */
// sort�p�z���C�g���X�g
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
// �\�[�g���e�̔c��
$sort_wk = (string)@$_GET['sort'];
$smarty_obj->assign('sort', $sort_wk);
if (isset($sort_list[$sort_wk])) {
    $sort = $sort_list[$sort_wk];
} else {
    $sort = 'created_at DESC';
}
// ���������̕ۑ�
$smarty_obj->assign('find_query', http_build_query($find_uri_params));
// �v���y�A�h�X�e�[�g�����g�̍쐬
$sql = 'SELECT * FROM inquiry';
if ([] !== $where) {
    $sql .= ' WHERE ' . implode(' AND ', $where);
}
$sql .= ' ORDER BY ' . $sort .' LIMIT 0, 20;';
$pre = $dbh->prepare($sql);
// �l���o�C���h
foreach($where_data  as  $k => $v) {
    $pre->bindValue($k, $v); // XXX �S��string�Ȃ̂ő�O�����͐F�X�ȗ�
}
// SQL�̎��s
$r = $pre->execute();
//�f�[�^���擾
$data = $pre->fetchAll();
$smarty_obj->assign('data', $data);
// �o��
$tmp_filename = 'admin_list.tpl';
require_once('./fin.php');