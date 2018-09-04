<?php 

$raw_pass = 'pass';
$pass = password_hash($raw_pass, PASSWORD_DEFAULT, ['cost' => 12]);
var_dump($raw_pass,  $pass);

var_dump( password_verify($raw_pass, $pass) );
var_dump( password_verify('pass2'  , $pass) );