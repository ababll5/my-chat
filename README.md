# my-chat
一个简约的chat

### 演示

演示图片：



![image](https://github.com/user-attachments/assets/65ec8c7f-b424-49d6-9c64-30cfca38eb7a)
![image](https://github.com/user-attachments/assets/23d494ae-0698-4efc-accf-6fe171bdf20b)
![image](https://github.com/user-attachments/assets/246b294c-194a-4490-ba4f-0c69d35fa696)

### 部署教程

[点我去下载源码](https://github.com/ababll5/my-chat/releases/)    
> 最好下载最新版


这里推荐宝塔来完成以下操作

### 后端

打开`admin`文件夹，在里面打开cmd  
之后输入  
```js  
npm install ws  
```
什么！npm not found  
你就浏览器收nodejs下载安装就好了  

npm install ws后我们继续运行这串指令  
```js  
node main.js  
```  
这样后端就部署在了8115端口上  
> 记得开放防火墙  

有能力的，前端域名有ssl证书的，就反向代理`ws//ip:8115/`到你的后端域名  
> 反向代理的前后端不能用同一个域名(可以用不同的三级域名)

#### 不过这样子终端一退出后端就会停
宝塔面板里面有一个软件叫`进程守护器`  
![image](https://github.com/user-attachments/assets/f7e7d6ab-da1b-4481-bf0b-617be5c4f1ba)

安装好后像我这样配置
![image](https://github.com/user-attachments/assets/66d2d7a0-3434-4bb1-9609-dcd11a5cfb5b)



这样后端的部署就完成了    

### 前端

更简单用宝塔面板部署根目录就好了  


### 对接

打开`chat.php`  
找到![image](https://github.com/user-attachments/assets/85cdc701-8c70-41c8-b141-2208af65f41e)

地址写后端的`ws://ip:8115`或者`wss://域名/wss`

### 最后

打开你的前端网址玩就是了


### 最后的最后

不想折腾的但又想玩玩的可以找我，20元帮忙搭建一次
- 扣扣：369491854
- 绿泡泡：15913105505


如果喜欢我写的chat请点亮右上角的小星星  


土豪们能给点吗？
这对我帮助真的很大
![mm_reward_qrcode_1725805312884](https://github.com/user-attachments/assets/3742f540-6554-4e36-9216-0440390047cf)
![1729435322](https://github.com/user-attachments/assets/ffa3e110-5d90-41e7-90bf-d5526b65a0d8)


