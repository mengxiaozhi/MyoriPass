<?php 
    require 'config.php';
    // Set Session
    session_start();
    $user = $_SESSION['user'];  // 将用户信息存入会话

    // 获取当前小时数
    $currentHour = date("H");

    // 根据当前小时数选择问候语
    if ($currentHour >= 0 && $currentHour < 12) {
        $greeting = "上午好";
    } elseif ($currentHour >= 12 && $currentHour < 18) {
        $greeting = "中午好";
    } else {
        $greeting = "晚上好";
    }

    // QR-ID API
    date_default_timezone_set("Asia/Taipei");
    
    $userid = $user['email'];

    $useremail = hash('sha256', $user['email']);
    $username = hash('sha256', $user['name']);
    $usercountries = hash('sha256',$user['countries']);
    $currentDateTime = hash('sha256',date("Ymd").date("hi")); // Format the date and time

    $hashblock1 = hash('sha256', $useremail . $username );
    $hashblock2 = hash('sha256',$usercountries . $currentDateTime);
    $tophash = hash('sha256', $hashblock1 . $hashblock2);

    $hashdata = hash('sha256', $tophash . "苗栗國萬歲!");

    $qrContent = "https://pass.myori.org/?id=" . $userid . $hashdata; // Combine content

    // 用戶名遮罩
    $nameLength = mb_strlen($user['name'], 'UTF-8'); // 获取用户名长度（考虑多字节字符）
    
    if ($nameLength === 2) {
        $displayedName = mb_substr($user['name'], 0, 1, 'UTF-8') . '◯'; // 只显示第一个字符，最后一个字符用"◯"代替

    } else {
        $displayedName = mb_substr($user['name'], 0, 1, 'UTF-8') . str_repeat('◯', $nameLength - 2) . mb_substr($user['name'], -1, 1, 'UTF-8'); // 只显示头尾，中间用"O"代替
    }
    
    $response = array(
        "success" => true,
        "qrCodeUrl" =>  $qrContent,
        "countries" =>  $user['countries'],
        "displayedName" => $displayedName,
        "greeting" => $greeting
    );

    echo json_encode($response);