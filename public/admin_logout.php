<?php  // admin_logout.php
//
require_once('init.php');
// �F�����폜����
unset($_SESSION['admin_auth']);
//
header('Location: ./admin_index.php');