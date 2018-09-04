<?php
// XXX これは駄目！！！
$token = uniqid();
var_dump($token);

// XXX これもダメ
$token = sha1(microtime());
var_dump($token);

// この辺ならまぁ安全
//$token_base = random_bytes(512);
//$token = hash('sha512', $token_base);

$token = hash('sha512', random_bytes(512));
var_dump($token);