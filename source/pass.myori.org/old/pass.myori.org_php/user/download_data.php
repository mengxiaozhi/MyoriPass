<?php
session_start(); // 如果尚未启动会话，则启动会话

// 检查用户是否已登录
if (!isset($_SESSION['user'])) {
    echo '
        <script type="text/javascript">
            window.location.href = "/user";
        </script>
    ';
}

$user = $_SESSION['user'];

// 设置响应头，指示为CSV文件
header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="user_data.csv"');

// 创建一个文件句柄，将数据写入CSV
$output = fopen('php://output', 'w');

// 将CSV标题行写入文件
fputcsv($output, ['Email', '姓名', '國籍', '證件號碼', '出入國記錄']);

// 将用户数据写入CSV
fputcsv($output, [$user['email'], $user['name'], $user['countries'], $user['id']]);

// 关闭文件句柄
fclose($output);