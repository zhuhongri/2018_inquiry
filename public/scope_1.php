<?php
$g_val = 10; // �O���[�o���X�R�[�v
function hoge() {
    $l_val = 20; // ���[�J���X�R�[�v
    {
        $l2_val = 30; // ���[�J���X�R�[�v
    }
    var_dump($l_val); // OK
    var_dump($l2_val); // OK
    var_dump($g_val); // �g���Ȃ�����null���\�������
}

var_dump($g_val);
hoge();
var_dump($l_val); // �g���Ȃ�����null���\�������