<?php 
require '../config.php';

    $pdo = new PDO(
        'mysql:host=' . $config['host'] . ';
        dbname=' . $config['dbname'] . ';
        charset=utf8',$config['username'],$config['password']
    );

    date_default_timezone_set("Asia/Taipei");
    $currentDateTime = hash('sha256',date("Ymd").date("hi")); // Format the date and time

    $post_email = hash(256,$_POST['email']);
    $post_name = hash(256,$_POST['name']);
    $post_countries = hash(256,$_POST["countries"]);

    $post_hashblock1 = hash(256,$post_email . $post_name);
    $post_hashblock2 = hash(256,$post_countries . $currentDateTime);
    $post_tophash = hash('sha256', $post_hashblock1 . $post_hashblock2);
    $post_hashdata = hash('sha256', $post_tophash . "苗栗國萬歲!");

    //$userid = $user['email'];
    //$useremail = hash('sha256', $user['email']);
    //$username = hash('sha256', $user['name']);
    //$usercountries = hash('sha256',$user['countries']);
    //更改變量數值

    $hashblock1 = hash('sha256', $useremail . $username );
    $hashblock2 = hash('sha256',$usercountries . $currentDateTime);
    $tophash = hash('sha256', $hashblock1 . $hashblock2);

    $hashdata = hash('sha256', $tophash . "苗栗國萬歲!");

    if($post_hashdata = $hashdata){
        $response = array(
            "pass" => 1
        );
    }
    else{
        $response = array(
            "pass" => 0
        );
    }
    echo json_encode($response);
?>