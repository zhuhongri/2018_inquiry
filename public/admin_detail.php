<?php  
require_once('init_admin_auth.php');
// ID�̎擾
$id = (string)@$_GET['id'];
//var_dump($id);
// DB�n���h���̎擾
$dbh = db_connect($config);
// DB��������擾
// �v���y�A�h�X�e�[�g�����g���쐬
$sql = 'SELECT * FROM inquiry WHERE id = :id;';
$pre = $dbh->prepare($sql);
// �l���o�C���h
$pre->bindValue(':id', $id);
// SQL�����s
$r = $pre->execute();
// �f�[�^���擾
$data = $pre->fetch();
if (false === $data) {
    // �f�[�^���Ȃ�������ꗗ�ɂ�����΂�
    header('Location: ./admin_list.php');
    exit;
}
//var_dump($data);
// �w�肳�ꂽID�̖₢���킹���e���o��
$smarty_obj->assign('detail', $data);
// CSRF�̖��ߍ���
// TODO: token�̎����A�^�u�ŊJ������NG
$csrf_token = get_csrf_token();
$_SESSION['admin_csrf'] = $csrf_token;
$smarty_obj->assign('csrf_token', $csrf_token);
// �o��
$tmp_filename = 'admin_detail.tpl';
require_once('./fin.php');
