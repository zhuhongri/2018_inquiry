<?php  

function db_connect($config) {
    //
    static $dbh = null;
    if (null !== $dbh) {
        return $dbh;
    }
    $dsn = sprintf("mysql:dbname=%s;host=%s;charset=%s"
                , $config['db']['dbname']
                , $config['db']['host']
                , $config['db']['charset'] );
    $user = $config['db']['user'];
    $pass = $config['db']['pass'];
    
    // MySQL�ŗL�̐ݒ�
    $opt = [
        // �ÓI�v���[�X�z���_���w��
        PDO::ATTR_EMULATE_PREPARES => false,
        // �����֎~
        PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
    ];
    
    try {
        $dbh = new PDO($dsn, $user, $pass, $opt);
    } catch (PDOException $e) {
        echo 'DB Connect error: ', $e->getMessage();
        exit;
    }
    
//var_dump($dbh);
 
    return $dbh;
}