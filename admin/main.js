// WebSocket 服务器
const WebSocket = require('ws');
const wss = new WebSocket.Server({ port: 8115 });

wss.on('connection', function connection(ws) {
    console.log('客户端已连接');

    // 当客户端发送消息时，处理该消息并广播
    ws.on('message', function incoming(message) {
        console.log('收到消息:', message);

        // 解析消息，确保消息格式正确
        let parsedMessage;
        try {
            parsedMessage = JSON.parse(message);
            console.log('解析后的消息:', parsedMessage);
        } catch (error) {
            console.error('消息解析失败:', error);
            return; // 如果解析失败，不继续执行广播
        }

        // 将消息广播给所有已连接的客户端
        wss.clients.forEach(function each(client) {
            if (client.readyState === WebSocket.OPEN) {
                console.log('广播消息给客户端:', parsedMessage); // 打印广播的消息
                client.send(JSON.stringify(parsedMessage)); // 发送消息给客户端
            }
        });
    });

    ws.on('close', function() {
        console.log('客户端已断开连接');
    });
});

console.log('WebSocket 服务器已启动，端口 8115');
