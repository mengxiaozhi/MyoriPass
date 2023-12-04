<?php 
    //require 'config.php';
    // Set Session
    //session_start();
    //$user = $_SESSION['user'];  // 将用户信息存入会话
    //$post_userid = $user['email'];

    //if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //$email = $_POST['email'];
        //$post_hashdata = $_POST['hashdata'];
    //}

    //$useremail = hash('sha256', $user['email']);
    //$username = hash('sha256', $user['name']);
    //$usercountries = hash('sha256',$user['countries']);
    //$currentDateTime = hash('sha256',date("Ymd").date("hi")); // Format the date and time

    //$hashblock1 = hash('sha256', $useremail . $username );
    //$hashblock2 = hash('sha256',$usercountries . $currentDateTime);
    //$tophash = hash('sha256', $hashblock1 . $hashblock2);

    //$hashdata = hash('sha256', $tophash . "苗栗國萬歲!");

    //$qrContent = "https://pass.myori.org/?id=" . $userid . $hashdata; // Combine content

    // 用戶名遮罩
    //$nameLength = mb_strlen($user['name'], 'UTF-8'); // 获取用户名长度（考虑多字节字符）
    
    //if ($nameLength === 2) {
        //$displayedName = mb_substr($user['name'], 0, 1, 'UTF-8') . '◯'; // 只显示第一个字符，最后一个字符用"◯"代替

    //} else {
        //$displayedName = mb_substr($user['name'], 0, 1, 'UTF-8') . str_repeat('◯', $nameLength - 2) . mb_substr($user['name'], -1, 1, 'UTF-8'); // 只显示头尾，中间用"O"代替
    //}
    
    //$response = array(
        //"success" => true,
        //"email" => $useremail,
        //"countries" =>  $user['countries'],
        //"displayedName" => $displayedName,
    //);

    //echo json_encode($response);