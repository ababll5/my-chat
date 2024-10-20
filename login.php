<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $username = $data['username'];
    $password = $data['password'];

    // 从 config.json 中加载用户数据
    $configData = json_decode(file_get_contents('config.json'), true);
    
    // 检查用户名和密码
    if (isset($configData['users'][$username]) && password_verify($password, $configData['users'][$username]['password'])) {
        $_SESSION['username'] = $username;
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => '用户名或密码错误']);
    }
} else {
    echo json_encode(['success' => false, 'message' => '不支持的请求方法']);
}
?>
