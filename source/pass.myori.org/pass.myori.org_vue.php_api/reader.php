<?php 
    require 'config.php';

    session_start();
    $authorize = $_SESSION['user'];  // 将用户信息存入会话
    $authorize_user = $authorize['name'];

    // 生成随机编号的函数
    function generateRandomCode($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $Record_Code = '';
        for ($i = 0; $i < $length; $i++) {
            $Record_Code .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $Record_Code;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $qrdata = $_POST['qrdata'];
        $uid = substr($qrdata, 0, 16);
        $hashdata = substr($qrdata, 16); 

        // 使用PDO建立数据库连接
        try {
            $pdo = new PDO(
                'mysql:host=' . $config['host'] . ';
                dbname=' . $config['dbname'] . ';
                charset=utf8', $config['username'], $config['password']
            );
            // 根据您的数据库配置调整连接参数
        } catch (PDOException $e) {
            die('数据库连接失败：' . $e->getMessage());
        }

        // 在数据库中查询用户信息以获取基于uid的数据
        $stmt = $pdo->prepare("SELECT * FROM user WHERE uid = :uid");
        $stmt->bindParam(':uid', $uid, PDO::PARAM_STR);
        $stmt->execute();

        // 获取用户数据
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // 找到用户，对相关信息进行哈希处理
            $useruid = $user['uid'];

            $useremail = hash('sha256', $user['email']);
            $username = hash('sha256', $user['name']);
            $usercountries = hash('sha256', $user['countries']);
            $currentDateTime = hash('sha256', date("Ymd") . date("hi"));
            
            $timedate = date("YmdHis");

            $hashblock1 = hash('sha256', $useremail . $username);
            $hashblock2 = hash('sha256', $usercountries . $currentDateTime);
            $tophash = hash('sha256', $hashblock1 . $hashblock2);

            $hashdata = hash('sha256', $tophash . "苗栗國萬歲!");
            $qrContent =  $useruid . $hashdata; // Combine content

            // 用户名遮罩逻辑
            $nameLength = mb_strlen($user['name'], 'UTF-8');

            // 检查用户名中是否包含“政府”两字，如果包含，则不采取遮罩
            if (mb_strpos($user['name'], '苗栗國', 0, 'UTF-8') === false) {
                if ($nameLength === 2) {
                    $displayedName = mb_substr($user['name'], 0, 1, 'UTF-8') . '◯';
                } else {
                    $displayedName = mb_substr($user['name'], 0, 1, 'UTF-8') . str_repeat('◯', $nameLength - 2) . mb_substr($user['name'], -1, 1, 'UTF-8');
                }
            } else {
                // 如果用户名中包含“政府”两字，则不进行遮罩处理
                $displayedName = $user['name'];
            }

            // 仅当uid与授权用户的uid不同才继续进行授权逻辑
            if ($user['uid'] !== $authorize['uid']) {
                if ($qrdata === $qrContent) {
                    // 将数据插入到 record 表中
                    $recordCode = generateRandomCode(); // 生成随机编号
                    $insertStmt = $pdo->prepare("INSERT INTO record (uid, email, record_code, timedate, authorize_uid) VALUES (:uid, :email, :record_code, :timedate, :authorize_uid)");
                    $insertStmt->bindParam(':uid', $uid, PDO::PARAM_STR);
                    $insertStmt->bindParam(':email', $user['email'], PDO::PARAM_STR);
                    $insertStmt->bindParam(':record_code', $recordCode, PDO::PARAM_STR);
                    $insertStmt->bindParam(':timedate', $timedate, PDO::PARAM_STR);
                    $insertStmt->bindParam(':authorize_uid', $authorize['uid'], PDO::PARAM_STR);
                    $insertStmt->execute();
                    
                    // 准备响应
                    $response = array(
                        "success" => true,
                        "message" => '授權成功',
                        "authorize_user" => $authorize_user,
                        "time" => $timedate,
                        "recordCode" => $recordCode,
                        "displayedName" => $displayedName,
                    );

                    echo json_encode($response);
                } else {
                    // QR数据不匹配
                    $response = array(
                        "success" => false,
                        "message" => 'QR数据不匹配',
                    );

                    echo json_encode($response);
                }
            } else {
                // 不能授权给自己
                $response = array(
                    "success" => false,
                    "message" => '不能授权给自己',
                );

                echo json_encode($response);
            }
        } else {
            // 未找到用户
            $response = array(
                "success" => false,
                "message" => '未找到用户',
            );

            echo json_encode($response);
        }
    } else {
        // 请求方法不是POST
        $response = array(
            "success" => false,
            "message" => '非法请求',
        );
        
        echo json_encode($response);
    }
?>