<?php
// 数据库连接配置
$config = array(
    'host' => 'localhost',
    'dbname' => 'myoripass',
    'username' => 'myoripass',
    'password' => 'myoripass233',
);

header('Access-Control-Allow-Origin:https://localhost');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With,X-PINGOTHER,Content-Type'); 
header('Access-Control-Allow-Methods:POST,GET,OPTIONS'); 
header('Access-Control-Allow-Credentials: true');
ini_set("display_errors", "On");