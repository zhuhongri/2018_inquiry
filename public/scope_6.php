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
    // cloneのブロック
    private function __clone() {
    }
    // unserializeのブロック
    public function __wakeup() {
        throw new Exception();
    }
}

//$obj = new Singleton();
$obj = Singleton::getInstance();
var_dump($obj);
// ブロック済
//$obj2 = clone($obj);
//var_dump($obj2);
// ブロック済
//$s = serialize($obj);
//var_dump($s);
//$obj2 = unserialize($s);
//var_dump($obj2);