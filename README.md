建议服务器在国内的用户使用这个插件，国外的服务器有点慢，服务器的二次验证会因为网速问题无法加载插件。

演示站点：[https://typecho.strcpy.cn](https://typecho.strcpy.cn)

### 更新版本说明

 - 1.0.3
 	1. 极验证SDK升级
 	2. Typecho接口更新兼容。
 	
 	`注：发现好多在使用插件的用户都出现了问题，原因是之前在Geetest.php中直接可以获取到Typecho的option对应的字段，现在似乎并不能获取，所以暂时引入临时文件保存。极验证的SDK更新为3。下一个版本会是个大版本，升级至1.1。`
 
 - 1.0.2
	带评论框与不带评论框的页面进行了判断，解决了首页等不评论框的页面 F12，console页报错问题加入了统计代码，统计插件展示次数。统计结果显示页面：[https://jinfeijie.cn/counts.php](https://jinfeijie.cn/counts.php)

 - 1.0.1
	[@DOMEIGANBATTE](https://gfwboom.com/)提醒，可在评论框中查找最后一个p，当做提交按钮，因此修改了部分代码。代码的适配模板更

 - 1.0.0
	集成极验证，制作了基于极验证的Typecho插件


### 插件信息
* 插件名称 : 极验证 For Typecho
* 插件版本 : 1.0.3
* 插件用途 : 避免发帖机器人评论
* 插件技术支持 : [geetest.com](https://www.geetest.com/)
* 插件升级支持 : [https://jinfeijie.cn](https://jinfeijie.cn)

---

### 插件配置
* CAPTCHA_ID : 如下图ID
* PRIVATE_KEY : 如下图KEY

![极验证后台](https://static.jinfeijie.cn/wp-content/uploads/2018/02/22d1ccc3f1639d1dd82055511ba2ae03.png)

---

### 使用方法
下载代码至`usr/plugins`，解压后进入后台启用插件。

### 下载链接
`wget https://jinfeijie.cn/Doc/Geetest.zip`

### 解压方法
`unzip Geetest.zip`






