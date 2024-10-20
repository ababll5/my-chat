<?php
// chat.php
session_start(); // 启用会话

// 检查用户是否登录
if (!isset($_SESSION['username'])) {
    header("Location: index.php"); // 重定向到登录页面
    exit();
}

$username = $_SESSION['username']; // 获取用户名
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>聊天室</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #e0f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 400px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .chat-container {
            display: flex;
            flex-direction: column;
            width: 100%;
            height: 600px;
        }

        .chat-header {
            background-color: #00796b;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 1.2rem;
        }

        #chat-box {
            flex-grow: 1;
            padding: 10px;
            overflow-y: auto;
            background-color: #fafafa;
            display: flex;
            flex-direction: column;
        }

        .chat-message {
            background-color: #00796b;
            color: white;
            padding: 10px;
            border-radius: 15px;
            margin: 5px 0;
            width: fit-content;
            max-width: 80%;
            word-wrap: break-word;
        }

        .chat-message.user-message {
            background-color: #004d40;
            align-self: flex-end;
        }

        .chat-message.other-message {
            background-color: #00796b;
            align-self: flex-start;
        }

        .message-meta {
            font-size: 0.8rem; /* 设置字体大小 */
            color: #ffffff; /* 设置颜色 */
            margin-bottom: 5px; /* 增加与消息内容的间距 */
            text-align: left; /* 左对齐 */
        }

        #message-input {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 25px;
            width: calc(100% - 100px);
            margin-right: 10px;
            font-size: 1rem;
        }

        #send-btn {
            background-color: #00796b;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #send-btn:hover {
            background-color: #004d40;
        }

        .chat-footer {
            display: flex;
            padding: 15px;
            background-color: #eeeeee;
        }
    </style>
</head>
<body>

<div class="container chat-container" id="chat-container">
    <div class="chat-header">
        WebSocket Chat - <?php echo htmlspecialchars($username); ?> <!-- 显示用户名 -->
    </div>
    <div id="chat-box">
        <!-- 聊天消息将在此显示 -->
    </div>
    <div class="chat-footer">
        <input type="text" id="message-input" placeholder="输入消息" autocomplete="off">
        <button id="send-btn">发送</button>
    </div>
</div>

<script>
let username = '<?php echo htmlspecialchars($username); ?>'; // 从PHP获取用户名
let socket;

// 初始化 WebSocket 连接
function initWebSocket() {
    socket = new WebSocket('wss://admin-im.ababll5.cn/wss');

    socket.onopen = function() {
        console.log('WebSocket 连接已打开');
        startPing(); // 启动心跳机制
    };

    socket.onmessage = function(event) {
        try {
            const msg = JSON.parse(event.data);
            if (msg && msg.sender && msg.content) {
                if (msg.sender !== username) {
                    displayMessage(msg);
                }
            }
        } catch (error) {
            console.error('解析消息失败:', error);
        }
    };

    socket.onerror = function(error) {
        console.error('WebSocket 错误:', error);
    };

    socket.onclose = function() {
        console.log('WebSocket 连接已关闭');
        reconnect();
    };
}

// 启动心跳机制
function startPing() {
    setInterval(() => {
        if (socket.readyState === WebSocket.OPEN) {
            socket.send(JSON.stringify({ type: 'ping' })); // 发送心跳消息
        }
    }, 30000); // 每30秒发送一次心跳
}

// 发送消息
document.getElementById('send-btn').addEventListener('click', function() {
    const messageContent = document.getElementById('message-input').value.trim();
    if (messageContent) {
        const message = {
            sender: username,
            content: messageContent,
            timeStr: new Date().toLocaleString()
        };

        displayMessage(message, true);
        socket.send(JSON.stringify(message));
        document.getElementById('message-input').value = ''; // 清空输入框
    }
});

// 显示消息
function displayMessage(msg, isUserMessage = false) {
    const chatBox = document.getElementById('chat-box');
    const messageElement = document.createElement('div');
    messageElement.classList.add('chat-message');

    const metaElement = document.createElement('div');
    metaElement.classList.add('message-meta');
    metaElement.textContent = `${msg.sender} [${msg.timeStr}]`;

    const contentElement = document.createElement('div');
    contentElement.textContent = msg.content;

    messageElement.classList.add(msg.sender === username ? 'user-message' : 'other-message');

    messageElement.appendChild(metaElement);
    messageElement.appendChild(contentElement);
    chatBox.appendChild(messageElement);
    chatBox.scrollTop = chatBox.scrollHeight; // 自动滚动到最新消息
}

// 允许通过回车键发送消息
document.getElementById('message-input').addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
        document.getElementById('send-btn').click(); // 触发发送按钮的点击事件
    }
});

// 页面加载时初始化WebSocket
window.onload = function() {
    initWebSocket();
};
</script>

</body>
</html>
