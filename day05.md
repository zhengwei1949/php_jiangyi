## 引言
我们在导言的时候，说过了，我们的php可以获取到表单传过来的数据

## GET和POST
- 除了表单提交的时候指定提交的方法是post,其他的全是get的提交方式 
- get方式
    + 表单的method是get
    + a链接
    + 直接在地址栏输入

### 分页思路

```
header("content-type:text/html;charset=utf8");
echo "<pre>";
// 预定义变量
print_r($_GET);
// echo '请求的页码为'.$_GET['page'];
$page = $_GET['page'];

// 通过limit子句实现查询数据的分页显示
// select  * from goods limit 4,2;
$pagesize = 2;
// 偏移量
$offset = ($page -1) * $pagesize ;

// 组装SQL语句
$sql ="select * from goods limit $offset,$pagesize";
die($sql);
// select * from goods limit 4,2
```

### 跳转

```php
<?php 
header('location:http://www.baidu.com');
?>
```

```php
<?php 
header('refresh:5;url=http://www.baidu.com');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <p>还有<span id="sec">5</span>秒跳转</p>
    <script>
    window.onload = function(){
        var sec = document.querySelector('#sec');
        setInterval(function(){
            sec.innerHTML = parseInt(sec.innerHTML) - 1;
        },1000);
    }
    </script>
</body>
</html>
```

## js端的跳转
- location.assign
- location.href

## GET与POST的区别
- GET不安全，且长度有限定
- POST更安全，可用于传输大的数据、上传文件

```
如：IE对URL长度的限制是2083字节(2K+35)。

下面就是对各种浏览器和服务器的最大处理能力做一些说明.

Microsoft Internet Explorer (Browser)

IE浏览器对URL的最大限制为2083个字符，如果超过这个数字，提交按钮没有任何反应。
Firefox (Browser)

对于Firefox浏览器URL的长度限制为65,536个字符。

Safari (Browser)

URL最大长度限制为 80,000个字符。

Opera (Browser)

URL最大长度限制为190,000个字符。

Google (chrome)

URL最大长度限制为8182个字符。

Apache (Server)

能接受最大url长度为8,192个字符。

Microsoft Internet Information Server(IIS)

能接受最大url的长度为16,384个字符。

通过上面的数据可知，为了让所有的用户都能正常浏览， URL最好不要超过IE的最大长度限制(2083个字符），当然，如果URL不直接提供给用户，而是提供给程序调用，这时的长度就只受Web服务器影响了。

注：对于中文的传递，最终会为urlencode后的编码形式进行传递，如果浏览器的编码为UTF8的话，一个汉字最终编码后的字符长度为9个字符。

因此如果使用的 GET 方法，最大长度等于URL最大长度减去实际路径中的字符数。


```

-----> 关于预定义变量，除了$_GET、$_POST,还有很多：

## 预定义变量(超全局变量)
- $_GET：获取所有表单以get方式提交的数据
- $_POST：POST提交的数据都会保存在此
- $_REQUEST：GET和POST提交的都会保存
- $GLOBALS：PHP中所有的全局变量
- $_SERVER：服务器信息 了解即可
- $_ENV：环境信息 了解即可
- $_FILES：用户上传的文件信息 后面会学
- $_SESSION：session会话数据 后面会学
- $_COOKIE：cookie会话数据 后面会学

## POST综合案例

### 下拉菜单相关

#### 下拉菜单提交数据

```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="" method="POST">
    最喜欢的车：
        <select name="car">
            <option value="BMW">BMW</option>
            <option value="BENZ">BENZ</option>
            <option value="Fararri">Fararri</option>
            <option value="AUDI">AUDI</option>
            <option value="INFINITI">INFINITI</option>
        </select>
        <input type="submit" value="提交">
    </form>
</body>
</html>
```

#### 下拉菜单数据接收

```php
<?php 
$car = $_POST['car'];
echo $car;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="" method="POST">
    最喜欢的车：
        <select name="car">
            <option value="BMW">BMW</option>
            <option value="BENZ">BENZ</option>
            <option value="Fararri">Fararri</option>
            <option value="AUDI">AUDI</option>
            <option value="INFINITI">INFINITI</option>
        </select>
        <input type="submit" value="提交">
    </form>
</body>
</html>
```

#### 防止出现警告提示信息

```php
<?php 
if(!empty($_POST)){
    $car = $_POST['car'];
    echo $car;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="" method="POST">
    最喜欢的车：
        <select name="car">
            <option value="BMW">BMW</option>
            <option value="BENZ">BENZ</option>
            <option value="Fararri">Fararri</option>
            <option value="AUDI">AUDI</option>
            <option value="INFINITI">INFINITI</option>
        </select>
        <input type="submit" value="提交">
    </form>
</body>
</html>
```

#### 根据下拉菜单接收的POST数据，对下拉表单设置默认值

```php
<?php 
if(!empty($_POST)){
    $car = $_POST['car'];
    echo $car;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="" method="POST">
    最喜欢的车：
        <select name="car">
            <option value="BMW" <?php if(isset($car) && $car == 'BMW')echo 'selected'?>>BMW</option>
            <option value="BENZ" <?php if(isset($car) && $car == 'BENZ')echo 'selected'?>>BENZ</option>
            <option value="Fararri" <?php if(isset($car) && $car == 'Fararri')echo 'selected'?>>Fararri</option>
            <option value="AUDI" <?php if(isset($car) && $car == 'AUDI')echo 'selected'?>>AUDI</option>
            <option value="INFINITI" <?php if(isset($car) && $car == 'INFINITI')echo 'selected'?>>INFINITI</option>
        </select>
        <input type="submit" value="提交">
    </form>
</body>
</html>
```

### 单选框数据处理

```php
<?php 
print_r($_POST);
if(!empty($_POST)){
    $car = $_POST['car'];
    echo $car;
    $sex = $_POST['sex'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="" method="POST">
    最喜欢的车：
        <select name="car">
            <option value="BMW" <?php if(isset($car) && $car == 'BMW')echo 'selected'?>>BMW</option>
            <option value="BENZ" <?php if(isset($car) && $car == 'BENZ')echo 'selected'?>>BENZ</option>
            <option value="Fararri" <?php if(isset($car) && $car == 'Fararri')echo 'selected'?>>Fararri</option>
            <option value="AUDI" <?php if(isset($car) && $car == 'AUDI')echo 'selected'?>>AUDI</option>
            <option value="INFINITI" <?php if(isset($car) && $car == 'INFINITI')echo 'selected'?>>INFINITI</option>
        </select>
    性别：
    <input type="radio" name="sex" value="1" <?php if(isset($sex) && $sex =='1' )echo 'checked';?>>男
    <input type="radio" name="sex" value="2" <?php if(isset($sex) && $sex =='2' )echo 'checked';?>>女
        <input type="submit" value="提交">
    </form>
</body>
</html>
```

### 复选框的数据处理

```php
<?php 
header("content-type:text/html;charset=utf8");
if(!empty($_POST)){
	// print_r($_POST);die;
	$car =$_POST['car'];
	$sex =$_POST['sex'];
	$books=$_POST['books'];//数组
	// print_r($books);
	$books =implode(',',$books);//字符串
	echo $car.'---'.$sex.'---'.$books;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>Examples</title>
<meta name="description" content="">
<meta name="keywords" content="">
<link href="" rel="stylesheet">
</head>
<body>
    <form action="" method="POST">
    	最喜欢的车：
    	<select name="car" id="">
    		<option value="BMW" <?php if(isset($car) && $car == 'BMW' ) echo 'selected'?>>BMW</option>
    		<option value="BENZ" <?php if(isset($car) && $car == 'BENZ' ) echo 'selected'?>>BENZ</option>
    		<option value="Fararri" <?php if(isset($car) && $car == 'Fararri' ) echo 'selected'?>>Fararri</option>
    		<option value="AUDI" <?php if(isset($car) && $car == 'AUDI' ) echo 'selected'?>>AUDI</option>
    		<option value="INFINITI" <?php if(isset($car) && $car == 'INFINITI' ) echo 'selected'?>>INFINITI</option>
    	</select><br />
    	性别：
    	<input type="radio" name="sex" id="" value="1" <?php if(isset($sex) && $sex == 1) echo 'checked'?>>男
    	<input type="radio" name="sex" id="" value="2" <?php if(isset($sex) && $sex == 2) echo 'checked'?>>女
    	<input type="radio" name="sex" id="" value="3" <?php if(isset($sex) && $sex == 3) echo 'checked'?>>中<br />
    	最喜欢的书：
    	<input type="checkbox" name="books[]" id="" value="我是小说家">我是小说家
    	<input type="checkbox" name="books[]" id="" value="岁月留痕">岁月留痕
    	<input type="checkbox" name="books[]" id="" value="白夜行">白夜行
    	<input type="checkbox" name="books[]" id="" value="诗经">诗经<br />
    	<input type="submit" value="提交">
    </form>
</body>
</html>
```

## 学生信息注册(38:00 自己做出来)
传智播客黑马程序员在全国各个小区开设各个专业、诸多班级。现在系统中录入学生，包括学生的学号、姓名，班级，手机号、邮箱等信息。


设计稿如下：

![](./学生信息添加.png)

前端工程师提供的静态代码如下：

```html
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>学生信息注册</title>
</head>
<body>
	<form>
		<table width="60%" align="center" border="1" rules="all" cellpadding="10">
			<caption><h2>添加学生</h2></caption>
			<tr>
				<th>学生姓名</th>
				<td><input type="text" name="name" id=""></td>
			</tr>
			<tr>
				<th>班级</th>
				<td><select name="class_id" id="">
					<option value="1">北京前端1</option>
					<option value="2">上海前端1</option>
					<option value="3">深圳JavaEE1</option>
					<option value="4">北京PHP1</option>
				</select></td>
			</tr>
			<tr>
				<th>手机号</th>
				<td><input type="text" name="tel" id=""></td>
			</tr>
			<tr>
				<th>邮箱地址</th>
				<td><input type="text" name="mail" id=""></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" value="注册"></td>
			</tr>			
		</table>
	</form>
</body>
</html>
```

思考用户操作逻辑：
1. 用户填写好表单
2. 点击提交按钮
3. php获取数据(用POST)
4. 构建插入SQL语句

### 第一步、完善表单html代码

```php
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>学生信息注册</title>
</head>
<body>
	<form action="./student_add_post.php" method="POST">
		<table width="60%" align="center" border="1" rules="all" cellpadding="10">
			<caption><h2>添加学生</h2></caption>
			<tr>
				<th>学生姓名</th>
				<td><input type="text" name="name" id=""></td>
			</tr>
			<tr>
				<th>班级</th>
				<td><select name="class_id" id="">
					<option value="1">北京前端1</option>
					<option value="2">上海前端1</option>
					<option value="3">深圳JavaEE1</option>
					<option value="4">北京PHP1</option>
				</select></td>
			</tr>
			<tr>
				<th>手机号</th>
				<td><input type="text" name="tel" id=""></td>
			</tr>
			<tr>
				<th>邮箱地址</th>
				<td><input type="text" name="mail" id=""></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" value="注册"></td>
			</tr>			
		</table>
	</form>
</body>
</html>
```


### 第二步、构建接收POST数据的php文件代码(阶段一：大家一起照着做出来)

```php
<?php 
header('content-type:text/html;charset=utf8');
print_r($_POST);
?>
```

### 第三步、创建数据库
![](./Snipaste_2018-03-22_15-28-31.png)

### 第四步、设计表

设计数据库表的原则：
1、默认一张表
2. 一个表单文本框对应一个字段
3. 再添加一个id


```
stu_id 学生id
stu_name 学生名字
class_name 班级名称
tel 电话
mail 邮箱
major 专业
tutor 班主任名称
start_time 开班时间
```

4、当把表设计好之后，看一下哪些字段比较冗余
    + class_name冗余
    + major冗余
    + tutor冗余
    + start_time冗余
5、把冗余的提取出来作为一个新的表 --> 拆表

```
//my_student表
stu_id int primary key auto_increment
stu_name varchar
class_id int
tel char(11)
mail 
```

```
//my_class表
class_id
class_name
major
tutor
start_time
```


![](./设计学生信息表.png)

