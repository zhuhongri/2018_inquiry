<?php

function hoge() {
    static $i = 0; // •Ï”Žõ–½‚ª‚µ‚Ô‚Æ‚­‚È‚Á‚ÄA¶‚«Žc‚é
    $i ++;
    var_dump($i);
}

hoge();
hoge();
hoge();
