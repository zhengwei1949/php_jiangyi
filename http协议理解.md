
# 一个http的请求响应过程

=====> 请求头中附带的信息
## Request Headers 查看HTTP请求内容
- Request URL:http://www.baidu.com/ 请求的URL地址
- Request Method:GET 请求的方法
- Status Code:200 OK HTTP的状态码
- Remote Address:180.97.33.108:80 请求的ip地址及端口
- Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8
- Accept-Encoding:gzip, deflate, br
- Accept-Language:zh-CN,zh;q=0.9,en;q=0.8,zh-TW;q=0.7
- Cache-Control:no-cache 控制缓存（例如：max-age=60 缓存 60 秒）
- Connection:keep-alive
- Cookie:BD_UPN=12314753; BDUSS=5ZdTFJVUk2c1ZaY3lPWVNWZmJpaU5EaHlzbmpOcnF6NVZEfkMta2xGVUx-c2xhQVFBQUFBJCQAAAAAAAAAAAEAAAAkSpImd2luZHllcmljemhlbmcAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAtxoloLcaJaSm; PSTM=1522336987; BIDUPSID=3C4566A7EF20D7A8210561F41FFE42C4; BAIDUID=40B9DEE254B18D924FA35DD1217A93D7:FG=1; MCITY=-340%3A; BDORZ=B490B5EBF6F3CD402E515D22BCDA1598; H_PS_PSSID=1434_21084_20930; BDRCVFR[feWj1Vr5u3D]=I67x6TjHwwYf0; BD_CK_SAM=1; PSINO=3; BD_HOME=1; H_PS_645EC=9dfdC%2BjUCyDm8fincqmW4qoh%2BS5eXbWiv%2F1k1sJlZdkkzacnpi%2BV91prpq6i3c1otcU7; sug=0; sugstore=0; ORIGIN=2; bdime=0
- Host:www.baidu.com
- User-Agent:Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.119 Safari/537.36 标识什么客户端帮你发送的这次请求

<====响应加来的内容
第一部分 响应头
## Response Headers 查看HTTP响应内容  
- HTTP/1.1 200 OK
- Connection: Keep-Alive
- Content-Type: text/html;charset=utf-8
- Date: Tue, 03 Apr 2018 08:20:35 GMT
- Expires: Tue, 03 Apr 2018 08:20:35 GMT
- Set-Cookie: BDSVRTM=126; path=/ 查看HTTP请求头和响应头附带的cookie信息
- Set-Cookie: BD_HOME=1; path=/
- Set-Cookie: H_PS_PSSID=1434_21084_20930; path=/; domain=.baidu.com

第二部分内容 响应的正文部分

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    百度
</body>
</html>



# 总结(要记住的知识点)

## 状态码
- 200	ok	请求成功
- 302	found	重定向(比如jd.com之前的名字是360buy.com，为了引导客户同意到jd.com可以设置302)
- 403	forbidden	禁止访问
- 404	not found 	页面不存在
- 500	internal server error	服务器内部错误

## 请求方法
- get
- post

## 如何使用network
- 筛选请求

