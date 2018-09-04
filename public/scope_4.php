<?php
$g_val = 100;

function hoge() {
    var_dump($g_val); // 使えないのでnull
    // その１
    var_dump($GLOBALS['g_val']); // アクセスできる
    // その２
    global $g_val;
    var_dump($g_val); // アクセスできる
}

hoge();
