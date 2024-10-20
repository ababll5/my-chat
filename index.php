<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>聊天室登录</title>
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
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #00796b;
        }

        input {
            padding: 10px;
            width: 100%;
            margin-bottom: 20px;
            border-radius: 25px;
            border: 1px solid #ccc;
        }

        button {
            padding: 10px;
            background-color: #00796b;
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        button:hover {
            background-color: #004d40;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>登录聊天室</h2>
    <input type="text" id="username" placeholder="用户名" autocomplete="off">
    <input type="password" id="password" placeholder="密码" autocomplete="off">
    <button id="login-button">登录</button>
    <p>还没有账户？<a href="register.html">注册</a></p>
</div>

<script>
const loginButton = document.getElementById('login-button');

loginButton.addEventListener('click', function() {
    const username = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value.trim();

    if (username && password) {
        fetch('login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ username, password }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = 'chat.php'; // 登录成功后跳转到聊天界面
            } else {
                alert(data.message);
            }
        });
    } else {
        alert("用户名和密码不能为空");
    }
});
</script>

</body>
</html>
