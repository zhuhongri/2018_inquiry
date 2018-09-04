<?php  // admin_update.php
//
require_once('init_admin_auth.php');
// �ԐM���e���擾
$body = (string)@$_POST['response_body'];
//var_dump($body);
// ID���擾
$id = (string)@$_POST['id'];
//var_dump($id);
// CSRF�΍�
// token�̎擾
$token = (string)@$_POST['csrf'];
if ('' === $token) {
    $error_flg['csrf_error'] = 1;
}
// token�̔�r
if ($_SESSION['admin_csrf'] !== $token) { // XXX hash_equals
    $error_flg['csrf_error'] = 1;
}
unset($_SESSION['admin_csrf']); // ���g���؂�
// XXX TODO �G���[���b�Z�[�W
if (1 == @$error_flg['csrf_error']) {
    header('Location: ./admin_detail.php?id=' . rawurlencode($id));
    exit;
}
// DB�n���h���̎擾
$dbh = db_connect($config);
// �ԐM���e��DB�ɓo�^
// �v���y�A�h�X�e�[�g�����g���쐬
$sql = 'UPDATE inquiry 
           SET response_name = :response_name
             , response_body = :response_body
             , response_at = :response_at
         WHERE id = :id;';
$pre = $dbh->prepare($sql);
// �l���o�C���h
$pre->bindValue(':response_name', $_SESSION['admin_auth']['id']);
$pre->bindValue(':response_body', $body);
$pre->bindValue(':response_at', date('Y-m-d H:i:s'));
$pre->bindValue(':id', $id);
// SQL�����s
$r = $pre->execute();
// Location�ŏڍ׉�ʂɖ߂�
header('Location: ./admin_detail.php?id=' . rawurlencode($id));