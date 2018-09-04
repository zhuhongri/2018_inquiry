<?php

class  Singleton {
    
    protected function __construct() {
    }
    
    static public function getInstance() {
        static $obj = null;
        if (null === $obj) {
            $obj = new static;
        }
        return $obj;
    }
    // clone�̃u���b�N
    private function __clone() {
    }
    // unserialize�̃u���b�N
    public function __wakeup() {
        throw new Exception();
    }
}

//$obj = new Singleton();
$obj = Singleton::getInstance();
var_dump($obj);
// �u���b�N��
//$obj2 = clone($obj);
//var_dump($obj2);
// �u���b�N��
//$s = serialize($obj);
//var_dump($s);
//$obj2 = unserialize($s);
//var_dump($obj2);