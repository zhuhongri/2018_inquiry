<?php  // init_admin_auth.php
//
require_once('init.php');
// �F����
if (false === isset($_SESSION['admin_auth'])) {
    // ���O�C����񂪂Ȃ��̂�index�ɂ�����΂�
    header('Location: ./admin_index.php');
    exit;
}