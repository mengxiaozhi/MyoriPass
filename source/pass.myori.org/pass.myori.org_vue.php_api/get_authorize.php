<?php 
session_start();

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // 確保 $_SESSION['user'] 中有 UID
    if (isset($_SESSION['user']['uid'])) {
        $uid = $_SESSION['user']['uid'];

        // 使用PDO建立数据库连接
        try {
            $pdo = new PDO(
                'mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'] . ';charset=utf8',
                $config['username'],
                $config['password']
            );
            // 根据您的数据库配置调整连接参数
        } catch (PDOException $e) {
            die('数据库连接失败：' . $e->getMessage());
        }

       // 在数据库中查询用户信息以获取基于 uid 的数据，并通过 JOIN 操作获取对应的用户姓名
        $stmt = $pdo->prepare("
        SELECT r.uid, r.email, r.record_code, r.timedate, r.authorize_uid, u.name
        FROM record r
        LEFT JOIN user u ON r.uid = u.uid
        WHERE r.uid = :uid OR r.authorize_uid = :uid
        ");
        $stmt->bindParam(':uid', $uid, PDO::PARAM_STR);
        $stmt->execute();

        $userRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($userRecords)) {
            // 如果找到匹配的记录
            $response = array(
                "success" => true,
                "message" => '授權紀錄找到',
                "records" => $userRecords,
            );

            echo json_encode($response);
        } else {
            // 如果未找到匹配的记录
            $response = array(
                "success" => false,
                "message" => '無授權紀錄',
            );

            echo json_encode($response);
        }
    } else {
        // 如果 $_SESSION['user'] 中沒有 UID
        $response = array(
            "success" => false,
            "message" => '無法獲取用戶 UID',
        );

        echo json_encode($response);
    }
} else {
    // 请求方法不是GET
    $response = array(
        "success" => false,
        "message" => '非法请求',
    );

    echo json_encode($response);
}
