<?php
// local•Ï”‚ÌŽõ–½‚Í™R‚¢
function hoge($i) {
    var_dump($v_hoge); // –ˆ‰ñnull‚É‚È‚é
    $v_hoge = $i;
    var_dump($v_hoge); // ˆø”‚Ì’l‚ªo‚é
}
hoge(1);
hoge(2);
hoge(3);
