<?php
// XXX ����͑ʖځI�I�I
$token = uniqid();
var_dump($token);

// XXX ������_��
$token = sha1(microtime());
var_dump($token);

// ���̕ӂȂ�܂����S
//$token_base = random_bytes(512);
//$token = hash('sha512', $token_base);

$token = hash('sha512', random_bytes(512));
var_dump($token);