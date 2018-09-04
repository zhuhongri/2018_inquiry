<?php
$g_val = 10; // グローバルスコープ
function hoge() {
    $l_val = 20; // ローカルスコープ
    {
        $l2_val = 30; // ローカルスコープ
    }
    var_dump($l_val); // OK
    var_dump($l2_val); // OK
    var_dump($g_val); // 使えないからnullが表示される
}

var_dump($g_val);
hoge();
var_dump($l_val); // 使えないからnullが表示される