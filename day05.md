## 引言
我们在导言的时候，说过了，我们的php可以获取到表单传过来的数据

## GET和POST
- 除了表单提交的时候指定提交的方法是post,其他的全是get的提交方式 

## location对象
- location.refresh - location.assign - location.url 

## 预定义变量(超全局变量)
- $_GET：获取所有表单以get方式提交的数据
- $_POST：POST提交的数据都会保存在此
- $_REQUEST：GET和POST提交的都会保存
- $GLOBALS：PHP中所有的全局变量
- $_SERVER：服务器信息
- $_SESSION：session会话数据
- $_COOKIE：cookie会话数据
- $_ENV：环境信息
- $_FILES：用户上传的文件信息 

## 练习
写一个表单填写“用户信息”，要求出现所有的表单元素类型：文本框，密码框，单选，复选，下拉，隐藏域。php直接打印（var_dump）出提交信息
用$_SERVER全局变量，获取如下信息
文档根目录：
浏览当前页面的用户的 IP 地址：
域名：
当前运行脚本所在的服务器的 IP 地址。