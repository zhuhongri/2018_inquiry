<?php

function hoge() {
    static $i = 0; // �ϐ����������ԂƂ��Ȃ��āA�����c��
    $i ++;
    var_dump($i);
}

hoge();
hoge();
hoge();
