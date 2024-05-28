<?php
// header为了解决App端访问API，Nginx服务器有一样的配置
header('Access-Control-Allow-Origin:https://localhost:5173'); 
header('Access-Control-Allow-Methods:POST,GET,OPTIONS'); 
header('Access-Control-Allow-Credentials: true'); //App端保存cookie
header('Access-Control-Allow-Headers: DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type,Authorization'); 
ini_set('display_errors','on');     # 開啟錯誤輸出

// 数据库连接配置
$config = array(
    'host' => 'database_host',
    'dbname' => 'database_name',
    'username' => 'database_user',
    'password' => 'database_password',
);

// 设置 Cookie 的域名
//ini_set('session.cookie_domain', '.myori.org');
// 启用安全的 Cookie 传输
//ini_set('session.cookie_secure', '1');
// 设置 SameSite 属性
//ini_set('session.cookie_samesite', 'Lax');