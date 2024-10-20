<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $nickname = $data['nickname'];
    $email = $data['email'];
    $password = password_hash($data['password'], PASSWORD_DEFAULT); // 加密密码

    // 从 config.json 中加载用户数据
    $configFile = 'config.json';
    $configData = json_decode(file_get_contents($configFile), true);
    
    // 检查用户名是否已存在
    if (isset($configData['users'][$nickname])) {
        echo json_encode(['success' => false, 'message' => '用户名已存在']);
    } else {
        // 添加用户到 config.json
        $configData['users'][$nickname] = [
            'nickname' => $nickname,
            'email' => $email,
            'password' => $password
        ];
        file_put_contents($configFile, json_encode($configData, JSON_PRETTY_PRINT));
        echo json_encode(['success' => true]);
    }
} else {
    echo json_encode(['success' => false, 'message' => '不支持的请求方法']);
}
?>
