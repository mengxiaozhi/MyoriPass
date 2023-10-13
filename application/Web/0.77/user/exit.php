<?php
// 注销用户
session_start();
session_unset(); // 清除会话中的所有变量
session_destroy(); // 销毁会话
header('Location: /'); // 重定向到登录页面
exit();