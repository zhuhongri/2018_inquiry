<?php
// local�ϐ��̎����͙R��
function hoge($i) {
    var_dump($v_hoge); // ����null�ɂȂ�
    $v_hoge = $i;
    var_dump($v_hoge); // �����̒l���o��
}
hoge(1);
hoge(2);
hoge(3);
