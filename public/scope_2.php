<?php
function hoge() {
    $v_hoge = 100;
}
function foo() {
    var_dump($v_hoge); // �g���Ȃ��̂�null
}
hoge();
foo();
