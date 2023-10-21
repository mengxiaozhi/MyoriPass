<?php
// 注销用户
session_start();
session_unset(); // 清除会话中的所有变量
session_destroy(); // 销毁会话

// 返回JSON格式的响应表示成功登出
echo json_encode(['status' => 'success', 'message' => '成功登出']);
exit();