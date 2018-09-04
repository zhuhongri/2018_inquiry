<?php // input.php
require_once( __DIR__ . '/init.php');
// ���͒l�̎擾
/*
// ���낢��ȁu���͒l�̎擾���@�v
$name = (string)@$_POST['name'];
$name = @$_POST['name'] ?? ''; // PHP7�ȍ~
$name = (string)filter_input(INPUT_POST, 'name');
if (true === isset($_POST['name'])) {
    $name = $_POST['name'];
} else {
    $name = '';
}
*/
/*
// ����Łu�_���v�Ƃ͌���Ȃ����c�c
$name = @$_POST['name'] ?? '';
$address = @$_POST['address'] ?? '';
$body = @$_POST['body'] ?? '';
*/
//
$params = ['name', 'address', 'body'];
$input_data = []; // ���͒l�ۑ��p
foreach($params as $p) {
    $input_data[$p] = @$_POST[$p] ?? '';
}
//var_dump($input_data);
// validate
$error_flg = [];
// �uaddress �� body�v�͕K�{����
if ('' === $input_data['address']) {
    // �G���[
    $error_flg['address_empty'] = 1;
}
if ('' === $input_data['body']) {
    // �G���[
    $error_flg['body_empty'] = 1;
}
// CSRF�`�F�b�N
// token�̎擾
$token = (string)@$_POST['csrf'];
if ('' === $token) {
    $error_flg['csrf_error'] = 1;
}
// token�̔�r
if ($_SESSION['csrf'] !== $token) {
    $error_flg['csrf_error'] = 1;
}
unset($_SESSION['csrf']); // ���g���؂�
//
if ([] !== $error_flg) {
    // form.php�Ƀf�[�^��n��
    $_SESSION['input'] = $input_data;
    $_SESSION['error'] = $error_flg;
    // �G���[���������Ă�I�I
    header('Location: ./form.php');
    exit;
}
// DB�ւ̐ڑ�
$dbh = db_connect($config);
/* DB�ւ�INSERT */
// �������ꂽ��(�v���y�A�h�X�e�[�g�����g)�̍쐬
$sql = 'INSERT INTO inquiry(name, address, body, created_at)
               VALUES(:name, :address, :body, now());';
$pre = $dbh->prepare($sql);
//var_dump($pre); exit;
// �v���[�X�z���_�ւ̒l�̃o�C���h
$pre->bindValue(':name'   , $input_data['name'], PDO::PARAM_STR); // ������
$pre->bindValue(':address', $input_data['address']); // ������Ȃ�ȗ���
$pre->bindValue(':body'   , $input_data['body']);
// SQL�̎��s
$r = $pre->execute();
//var_dump( $dbh->errorInfo() );
//var_dump($r); exit;
//
header('Location: fin.html');