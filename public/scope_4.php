<?php
$g_val = 100;

function hoge() {
    var_dump($g_val); // �g���Ȃ��̂�null
    // ���̂P
    var_dump($GLOBALS['g_val']); // �A�N�Z�X�ł���
    // ���̂Q
    global $g_val;
    var_dump($g_val); // �A�N�Z�X�ł���
}

hoge();
