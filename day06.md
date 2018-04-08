## 引言
- 我们昨天做的案例：学生信息添加系统只做了一半，造出一个sql语句之后，接下来是我们人工的去数据库中去操作的，学完今天的东西之后，我们就可以把它完善

## 检测函数是否存在
- function_exists

## php操作数据库步骤

```php
<?php
header('content-type:text/html;charset=utf8');
$link = @mysql_connect('localhost:3306','root','root') or die('数据库忙');
var_dump($link);
?>
```

```php
<?php
header('content-type:text/html;charset=utf8');
$host = 'localhost:3306';
$user = 'root';
$password = 'root';
$link = @mysql_connect($host,$user,$password) or die('数据库忙');
var_dump($link);
?>
```

封装mysql连接

```
<?php
header('content-type:text/html;charset=utf8');
$conf = [];
$conf['host'] = 'localhost:3306';
$conf['user'] = 'root';
$conf['password'] = 'root';
$conf['charset'] = 'utf8';
$conf['db'] = 'fe';

function connect($conf = []){
    $link = @mysql_connect($conf['host'],$conf['user'],$conf['password']) or die('服务器忙');
    //设置字符集
    mysql_query('set names '.$conf['charset']);
    //选择数据库
    mysql_query('use '.$conf['db']) or die('数据库选择失败');
    return $link;//资源型
}

$link = connect($conf);

var_dump($link);
```


mysql_fetch_array,mysql_fetch_row,mysql_fetch_assoc类似于push,pop,每次得到的不一样


## 学生管理系统案例
### 第一步 先看最终的演示效果

### 第二步 提前准备好的静态页面

### 第三步 根据项目需求设计出来数据表
我们发现除了有学生的信息，还有班级的相关的信息，所以，设计两张表

```
my_stu表
- std_id 学生id
- stu_name 学生名称
- class_id 班级id
- tel 电话
- mail 邮箱

my_class表
- class_id 班级id
- class_name 班级名称
- major 专业
- tutor 班主任名称
- start_time 开班时间
```

这里，为了简化项目，直接把现成的sql语句生成项目需要的数据库及表：


```sql
create database itcast_student charset utf8;
use itcast_student;
#包括班级编号，班级名称，学习专业，班主任姓名
create table my_class(
class_id int primary key auto_increment,
class_name varchar(20) not null unique key,
major varchar(20),
tutor varchar(10),
start_time date
);

insert into my_class values 
	(null,'北京前端1','前端与移动开发','赵老师','2017-01-01'),
	(null,'上海前端1','前端与移动开发','王老师','2017-03-01'),
	(null,'深圳JavaEE1','JAVA','宋老师','2017-01-02'),
	(null,'北京PHP1','PHP','吴老师','2017-01-01');

#	录入学生的学号、姓名、年龄、性别，班级、手机号、电子照片等。
create table my_stu(
stu_id int primary key auto_increment,
stu_name varchar(10) not null unique key ,
age tinyint not null default 23,
sex char(2) not null default '保密',
class_id int,
tel char(11),
pics varchar(200)
);

insert into my_stu values 
	(null,'欧阳帅帅',23,'男',1,'13812345678','./upload/1.png'),
	(null,'欧阳娜娜',22,'女',2,'13812345678','./upload/1.png'),
	(null,'欧阳美美',18,'女',3,'13812345678','./upload/1.png'),
	(null,'欧阳斌斌',19,'男',1,'13812345678','./upload/1.png');

```

### 第四步 添加学生信息
1. 在网站根目录中创建一个目录student_demo
2. 把静态文件都拷贝进去
3. 把add.html修改为add.php,index.html修改为index.php,edit.html修改为edit.php,detail.html修改为detail.php
4. 班级名称不能写死，必须来自数据库，所以接下来咱们的任务就是从数据库中取出来所有的班级信息，然后动态渲染到add.php页面上，思路如下
    1. 创建数据库配置
    2. 连接数据库

```php
<?php 
$host = 'localhost:3306';
$user = 'root';
$password = 'root';
$charset = 'utf8';
$db = 'itcast_student';

$link = @mysql_connect($host,$user,$password) or die('数据库连接失败');
//设置编码
mysql_query('set names '.$charset);
//使用数据库
mysql_query('use '.$db);

var_dump($link);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<!-- 录入学生的学号、姓名、年龄、性别，班级、手机号、电子照片等。 -->
	<form >
		<table width="60%" cellpadding="8" border="1" rules="all" align="center">
			<caption><h2>添加学生</h2></caption>
			<tr>
				<th>学生姓名</th>
				<td><input type="text" name="stu_name" id=""></td>
			</tr>
			<tr>
				<th>年龄</th>
				<td><input type="text" name="age" id=""></td>
			</tr>
			<tr>
				<th>性别</th>
				<td>
					<input type="radio" name="sex" id="" value="男">男
					<input type="radio" name="sex" id="" value="女">女
					<input type="radio" name="sex" id="" value="保密" checked >保密
				</td>
			</tr>
			<tr>
				<th>班级</th>
				<td>
                    <select name="class_id" id="">
                        <option value="1">北京前端1</option>
                        <option value="2">上海前端1</option>
                        <option value="3">深圳JavaEE1</option>
                        <option value="4">北京PHP1</option>
					</select></td>
			</tr>
			<tr>
				<th>手机号</th>
				<td>
                    <input type="text" name="tel" id="">
                </td>
			</tr>
			<tr>
				<th>学生照片</th>
				<td>
                    <input type="file" name="up" id="">
                </td>
			</tr>
			<tr>
				<th></th>
				<td>
                    <input type="submit" value="添加">
                </td>
			</tr>
		</table>
	</form>
</body>
</html>	

```

    3. 查询班级数据

```php
<?php 
$host = 'localhost:3306';
$user = 'root';
$password = 'root';
$charset = 'utf8';
$db = 'itcast_student';

$link = @mysql_connect($host,$user,$password) or die('数据库连接失败');
//设置编码
mysql_query('set names '.$charset);
//使用数据库
mysql_query('use '.$db);

// var_dump($link);
$sql = 'select * from my_class';
$results = mysql_query($sql);
// var_dump($results);
// var_dump(mysql_error());
mysql_num_rows($results) > 0 or die('没有查询到数据');
$data = [];
while($row = mysql_fetch_assoc($results)){
	$data[] = $row;
}
print_r($data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<!-- 录入学生的学号、姓名、年龄、性别，班级、手机号、电子照片等。 -->
	<form >
		<table width="60%" cellpadding="8" border="1" rules="all" align="center">
			<caption><h2>添加学生</h2></caption>
			<tr>
				<th>学生姓名</th>
				<td><input type="text" name="stu_name" id=""></td>
			</tr>
			<tr>
				<th>年龄</th>
				<td><input type="text" name="age" id=""></td>
			</tr>
			<tr>
				<th>性别</th>
				<td>
					<input type="radio" name="sex" id="" value="男">男
					<input type="radio" name="sex" id="" value="女">女
					<input type="radio" name="sex" id="" value="保密" checked >保密
				</td>
			</tr>
			<tr>
				<th>班级</th>
				<td>
                    <select name="class_id" id="">
                        <option value="1">北京前端1</option>
                        <option value="2">上海前端1</option>
                        <option value="3">深圳JavaEE1</option>
                        <option value="4">北京PHP1</option>
					</select></td>
			</tr>
			<tr>
				<th>手机号</th>
				<td>
                    <input type="text" name="tel" id="">
                </td>
			</tr>
			<tr>
				<th>学生照片</th>
				<td>
                    <input type="file" name="up" id="">
                </td>
			</tr>
			<tr>
				<th></th>
				<td>
                    <input type="submit" value="添加">
                </td>
			</tr>
		</table>
	</form>
</body>
</html>	

```

    4. 进行php渲染


```php
<?php 
$host = 'localhost:3306';
$user = 'root';
$password = 'root';
$charset = 'utf8';
$db = 'itcast_student';

$link = @mysql_connect($host,$user,$password) or die('数据库连接失败');
//设置编码
mysql_query('set names '.$charset);
//使用数据库
mysql_query('use '.$db);

// var_dump($link);
$sql = 'select * from my_class';
$results = mysql_query($sql);
// var_dump($results);
// var_dump(mysql_error());
mysql_num_rows($results) > 0 or die('没有查询到数据');
$data = [];
while($row = mysql_fetch_assoc($results)){
	$data[] = $row;
}
print_r($data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<!-- 录入学生的学号、姓名、年龄、性别，班级、手机号、电子照片等。 -->
	<form >
		<table width="60%" cellpadding="8" border="1" rules="all" align="center">
			<caption><h2>添加学生</h2></caption>
			<tr>
				<th>学生姓名</th>
				<td><input type="text" name="stu_name" id=""></td>
			</tr>
			<tr>
				<th>年龄</th>
				<td><input type="text" name="age" id=""></td>
			</tr>
			<tr>
				<th>性别</th>
				<td>
					<input type="radio" name="sex" id="" value="男">男
					<input type="radio" name="sex" id="" value="女">女
					<input type="radio" name="sex" id="" value="保密" checked >保密
				</td>
			</tr>
			<tr>
				<th>班级</th>
				<td>
                    <select name="class_id" id="">
						<?php for($i=0;$i<count($data);$i++){?>						
                        	<option value="<?php echo $data[$i]['class_id']?>"><?php echo $data[$i]['class_name'] ?></option>
						<?php } ?>
					</select></td>
			</tr>
			<tr>
				<th>手机号</th>
				<td>
                    <input type="text" name="tel" id="">
                </td>
			</tr>
			<tr>
				<th>学生照片</th>
				<td>
                    <input type="file" name="up" id="">
                </td>
			</tr>
			<tr>
				<th></th>
				<td>
                    <input type="submit" value="添加">
                </td>
			</tr>
		</table>
	</form>
</body>
</html>	

```

    5. 把数据库连接相关的代码提取到公共文件connect.php

```php
//add.php
<?php 
include "./connect.php";
// var_dump($link);
$sql = 'select * from my_class';
$results = mysql_query($sql);
// var_dump($results);
// var_dump(mysql_error());
mysql_num_rows($results) > 0 or die('没有查询到数据');
$data = [];
while($row = mysql_fetch_assoc($results)){
	$data[] = $row;
}
// print_r($data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<!-- 录入学生的学号、姓名、年龄、性别，班级、手机号、电子照片等。 -->
	<form >
		<table width="60%" cellpadding="8" border="1" rules="all" align="center">
			<caption><h2>添加学生</h2></caption>
			<tr>
				<th>学生姓名</th>
				<td><input type="text" name="stu_name" id=""></td>
			</tr>
			<tr>
				<th>年龄</th>
				<td><input type="text" name="age" id=""></td>
			</tr>
			<tr>
				<th>性别</th>
				<td>
					<input type="radio" name="sex" id="" value="男">男
					<input type="radio" name="sex" id="" value="女">女
					<input type="radio" name="sex" id="" value="保密" checked >保密
				</td>
			</tr>
			<tr>
				<th>班级</th>
				<td>
                    <select name="class_id" id="">
						<?php for($i=0;$i<count($data);$i++){?>						
                        	<option value="<?php echo $data[$i]['class_id']?>"><?php echo $data[$i]['class_name'] ?></option>
						<?php } ?>
					</select></td>
			</tr>
			<tr>
				<th>手机号</th>
				<td>
                    <input type="text" name="tel" id="">
                </td>
			</tr>
			<tr>
				<th>学生照片</th>
				<td>
                    <input type="file" name="up" id="">
                </td>
			</tr>
			<tr>
				<th></th>
				<td>
                    <input type="submit" value="添加">
                </td>
			</tr>
		</table>
	</form>
</body>
</html>	

```


```php
//connect.php
<?php 
$host = 'localhost:3306';
$user = 'root';
$password = 'root';
$charset = 'utf8';
$db = 'itcast_student';

$link = @mysql_connect($host,$user,$password) or die('数据库连接失败');
//设置编码
mysql_query('set names '.$charset);
//使用数据库
mysql_query('use '.$db);
?>
```

    6. 修改form表单

```html
<form action="./insert.php" method="POST" enctype="multipart/form-data">
```

    7. 创建insert.php,接收用户POST的数据

```php
//insert.php
<?php 
header('content-type:text/html;charset=utf8');
print_r($_POST);
?>
```

    8. 处理文件上传

```php
<?php 
header('content-type:text/html;charset=utf8');
print_r($_POST);
// print_r($_FILES);
if(empty($_FILES)){
    die('非法登录');
}
$file = $_FILES['upload'];
//1. 判断文件上传是否有错误
if($file['error'] !=0){
    $errMsg = '';
    switch($file['error']){
        case 1:
            $errMsg = '超过2M';
            break;
        case 4:
            $errMsg = '未选择的文件';
            break;
        case 6:
            $errMsg = '临时路径出错';
            break;
        default:
            $errMsg = '未知错误';
    }

    die($errMsg);
}

//2. 判断是否是合法HTTP POST上传文件
if(!is_uploaded_file($file['tmp_name'])){
    die('非法上传文件');
}

//3. 判断文件大小是否满足要求1.1M
$maxSize = 1.1;
if($maxSize * 1024 * 1024 < $file['size']){
    die('文件大小超过'.$maxSize.'M');
}

//判断文件类型是否支持的类型
//1. 打开finfo资源
$resource = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($resource,$file['tmp_name']);
// var_dump($mime);
// die();

//网站支持的MIME类型
$mimeArr = ['image/png','image/jpeg'];
if(!in_array($mime,$mimeArr)){
    die('文件类型不支持');
}

//移动临时文件到永久路径
//永久路径 ./upload 
$ext = strrchr($file['name'],'.');
$savePath = './upload/'.date('YmdHis-').mt_rand(1000,9999).$ext;
// echo $savePath;

if(move_uploaded_file($file['tmp_name'],$savePath)){
    echo $file['name'].'上传成功';
}else{
    echo $file['name'].'移动发生错误';
}
```

    9. 把提交的数据插入到数据库当中
	10. 跳转到首页

```php
<?php 
header('content-type:text/html;charset=utf8');
include './connect.php';
// print_r($_POST);
// print_r($_FILES);
$file = $_FILES['upload'];
//1. 判断文件上传是否有错误
if($file['error'] !=0){
    $errMsg = '';
    switch($file['error']){
        case 1:
            $errMsg = '超过2M';
            break;
        case 4:
            $errMsg = '未选择的文件';
            break;
        case 6:
            $errMsg = '临时路径出错';
            break;
        default:
            $errMsg = '未知错误';
    }

    die($errMsg);
}

//2. 判断是否是合法HTTP POST上传文件
if(!is_uploaded_file($file['tmp_name'])){
    die('非法上传文件');
}

//3. 判断文件大小是否满足要求1.1M
$maxSize = 1.1;
if($maxSize * 1024 * 1024 < $file['size']){
    die('文件大小超过'.$maxSize.'M');
}

//判断文件类型是否支持的类型
//1. 打开finfo资源
$resource = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($resource,$file['tmp_name']);
// var_dump($mime);
// die();

//网站支持的MIME类型
$mimeArr = ['image/png','image/jpeg'];
if(!in_array($mime,$mimeArr)){
    die('文件类型不支持');
}

//移动临时文件到永久路径
//永久路径 ./upload 
$ext = strrchr($file['name'],'.');
$savePath = './upload/'.date('YmdHis-').mt_rand(1000,9999).$ext;
// echo $savePath;

if(move_uploaded_file($file['tmp_name'],$savePath)){
    // echo $file['name'].'上传成功';
    //开始构建插入SQL语句
    $stu_name = $_POST['stu_name'];
    $age = $_POST['age'];
    $sex = $_POST['sex'];
    $class_id = $_POST['class_id'];
    $tel = $_POST['tel'];
    $sql = "insert into my_stu (stu_name,age,sex,class_id,tel,pics) values('$stu_name',$age,'$sex',$class_id,'$tel','$savePath');";
    // echo '<br>';
    echo $sql;
    $result = mysql_query($sql);
    var_dump($result);
    if($result){
        //成功
        header('refresh:1;url=./index.php');
    }else{
        //失败
        echo '<script>alert("插入失败");history.go(-1);</script>';
    }
}else{
    echo $file['name'].'移动发生错误';
}
```

### 第五步 展示学生列表
1. 连接数据库
2. 查询学生列表数据

```php
<?php 
include './connect.php';
$sql = 'select * from my_stu';
$results = mysql_query($sql);
// var_dump(mysql_num_rows($results));
mysql_num_rows($results) > 0 or die('暂无数据');
$data = [];
while($row = mysql_fetch_assoc($results)){
	$data[] = $row;
}
// print_r($data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>首页</title>
</head>
<body>
	<table width="50%" border="1" rules="all" cellpadding="8" align="center">
		<caption><h2>学生列表</h2></caption>
		<tr>
			<td>学号</td>
			<td>姓名</td>
			<td>手机号</td>
			<td>操作</td>
		</tr>
		<tr>
			<td>1</td>
			<td><a href="#">欧阳帅帅</a></td>
			<td>13812345678</td>
			<td><a href="#">修改</a> || 删除</td>
		</tr>
		<tr>
			<td>1</td>
			<td><a href="#">欧阳帅帅</a></td>
			<td>13812345678</td>
			<td><a href="#">修改</a> || 删除</td>
        </tr>
        <tr>
			<td>1</td>
			<td><a href="#">欧阳帅帅</a></td>
			<td>13812345678</td>
			<td><a href="#">修改</a> || 删除</td>
        </tr>
        <tr>
			<td>1</td>
			<td><a href="#">欧阳帅帅</a></td>
			<td>13812345678</td>
			<td><a href="#">修改</a> || 删除</td>
		</tr>
	</table>
</body>
</html>
```

3. 渲染

```php
<?php 
include './connect.php';
$sql = 'select * from my_stu';
$results = mysql_query($sql);
// var_dump(mysql_num_rows($results));
mysql_num_rows($results) > 0 or die('暂无数据');
$data = [];
while($row = mysql_fetch_assoc($results)){
	$data[] = $row;
}
// print_r($data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>首页</title>
</head>
<body>
	<table width="50%" border="1" rules="all" cellpadding="8" align="center">
		<caption><h2>学生列表</h2></caption>
		<tr>
			<td>学号</td>
			<td>姓名</td>
			<td>手机号</td>
			<td>操作</td>
		</tr>
		<?php for($i=0;$i<count($data);$i++){ ?> 
		<tr>
			<td><?php echo $data[$i]['stu_id'] ?></td>
			<td><a href="#"><?php echo $data[$i]['stu_name'] ?></a></td>
			<td><?php echo $data[$i]['tel'] ?></td>
			<td><a href="#">修改</a> || 删除</td>
		</tr>
		<?php } ?>
	</table>
</body>
</html>
```

### 第六步 修改学生信息
- 修改其实和添加的逻辑有点类似，所以，我们直接拷贝添加的php代码过来

```php

<?php 
include "./connect.php";
// var_dump($link);
$sql = 'select * from my_class';
$results = mysql_query($sql);
// var_dump($results);
// var_dump(mysql_error());
mysql_num_rows($results) > 0 or die('没有查询到数据');
$data = [];
while($row = mysql_fetch_assoc($results)){
	$data[] = $row;
}
// print_r($data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<!-- 录入学生的学号、姓名、年龄、性别，班级、手机号、电子照片等。 -->
	<form action="update.php?stu_id=1" method="POST" enctype="multipart/form-data">
		<!-- <input type="hidden" name="stu_id" value="1"> -->
		<table width="60%" cellpadding="8" border="1" rules="all" align="center">
			<caption><h2>修改学生信息</h2></caption>
			<tr>
				<th>学生姓名</th>
				<td><input type="text" name="stu_name" id="" value="欧阳帅帅"></td>
			</tr>
			<tr>
				<th>年龄</th>
				<td><input type="text" name="age" id="" value="23"></td>
			</tr>
			<tr>
				<th>性别</th>
				<td>
					<input type="radio" name="sex" id="" value="男" checked>男
					<input type="radio" name="sex" id="" value="女" >女
					<input type="radio" name="sex" id="" value="保密" >保密
				</td>
			</tr>
			<tr>
				<th>班级</th>
				<td>
                    <select name="class_id" id="">
						<?php for($i=0;$i<count($data);$i++){?>						
                        	<option value="<?php echo $data[$i]['class_id']?>"><?php echo $data[$i]['class_name'] ?></option>
						<?php } ?>
					</select></td>
			</tr>
			<tr>
				<th>手机号</th>
				<td><input type="text" name="tel" id="" value="13812345678"></td>
			</tr>
			<tr>
				<th></th>
				<td><input type="submit" value="修改"></td>
			</tr>
		</table>
	</form>
</body>
</html>	


```


- 思考
用户操作逻辑：点击修改链接跳转到修改页面，进一步思考：为什么不同的修改可以知道要修改哪一个？ --> 通过id

```php
	<td><a href="./edit.php?stu_id=<?php echo $data[$i]['stu_id'] ?>">修改</a> || 删除</td>
```

add.php要做的事情是获取当前的id,然后去数据库当中查询到对应的数据

```php

<?php 
include "./connect.php";
// var_dump($link);
$sql = 'select * from my_class';
$results = mysql_query($sql);
// var_dump($results);
// var_dump(mysql_error());
mysql_num_rows($results) > 0 or die('没有查询到数据');
$data = [];
while($row = mysql_fetch_assoc($results)){
	$data[] = $row;
}
// print_r($data);

// print_r($_GET);
if(!empty($_GET)){
	$stu_id = $_GET['stu_id'];
}else{
	$stu_id = 1;
}
// echo $stu_id;
$sql1 = 'select * from my_stu where stu_id='.$stu_id;
$results1 = mysql_query($sql1);
mysql_num_rows($results1) > 0 or die('暂无数据');
$data1 = mysql_fetch_assoc($results1);
print_r($data1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<!-- 录入学生的学号、姓名、年龄、性别，班级、手机号、电子照片等。 -->
	<form action="" method="POST" enctype="multipart/form-data">
		<table width="60%" cellpadding="8" border="1" rules="all" align="center">
			<caption><h2>修改学生信息</h2></caption>
			<tr>
				<th>学生姓名</th>
				<td><input type="text" name="stu_name" id="" value="欧阳帅帅"></td>
			</tr>
			<tr>
				<th>年龄</th>
				<td><input type="text" name="age" id="" value="23"></td>
			</tr>
			<tr>
				<th>性别</th>
				<td>
					<input type="radio" name="sex" id="" value="男" checked>男
					<input type="radio" name="sex" id="" value="女" >女
					<input type="radio" name="sex" id="" value="保密" >保密
				</td>
			</tr>
			<tr>
				<th>班级</th>
				<td>
                    <select name="class_id" id="">
						<?php for($i=0;$i<count($data);$i++){?>						
                        	<option value="<?php echo $data[$i]['class_id']?>"><?php echo $data[$i]['class_name'] ?></option>
						<?php } ?>
					</select></td>
			</tr>
			<tr>
				<th>手机号</th>
				<td><input type="text" name="tel" id="" value="13812345678"></td>
			</tr>
			<tr>
				<th></th>
				<td><input type="submit" value="修改"></td>
			</tr>
		</table>
	</form>
</body>
</html>	

```

接下来去渲染到页面当中

```php

<?php 
include "./connect.php";
// var_dump($link);
$sql = 'select * from my_class';
$results = mysql_query($sql);
// var_dump($results);
// var_dump(mysql_error());
mysql_num_rows($results) > 0 or die('没有查询到数据');
$data = [];
while($row = mysql_fetch_assoc($results)){
	$data[] = $row;
}
// print_r($data);

// print_r($_GET);
if(!empty($_GET)){
	$stu_id = $_GET['stu_id'];
}else{
	$stu_id = 1;
}
// echo $stu_id;
$sql1 = 'select * from my_stu where stu_id='.$stu_id;
$results1 = mysql_query($sql1);
mysql_num_rows($results1) > 0 or die('暂无数据');
$data1 = mysql_fetch_assoc($results1);
print_r($data1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<!-- 录入学生的学号、姓名、年龄、性别，班级、手机号、电子照片等。 -->
	<form action="" method="POST" enctype="multipart/form-data">
		<table width="60%" cellpadding="8" border="1" rules="all" align="center">
			<caption><h2>修改学生信息</h2></caption>
			<tr>
				<th>学生姓名</th>
				<td><input type="text" name="stu_name" id="" value="<?php echo $data1['stu_name'];?>"></td>
			</tr>
			<tr>
				<th>年龄</th>
				<td><input type="text" name="age" id="" value="<?php echo $data1['age'];?>"></td>
			</tr>
			<tr>
				<th>性别</th>
				<td>
					<input type="radio" name="sex" id="" value="男" <?php echo $data1['sex']=='男'?'checked':'';?>>男
					<input type="radio" name="sex" id="" value="女" <?php echo $data1['sex']=='女'?'checked':'';?>>女
					<input type="radio" name="sex" id="" value="保密" <?php echo $data1['sex']=='保密'?'checked':'';?>>保密
				</td>
			</tr>
			<tr>
				<th>班级</th>
				<td>
                    <select name="class_id" id="">
						<?php for($i=0;$i<count($data);$i++){?>						
                        	<option value="<?php echo $data[$i]['class_id']?>" <?php echo $data1['class_id']==$data[$i]['class_id']?'selected':'';?>><?php echo $data[$i]['class_name'] ?></option>
						<?php } ?>
					</select></td>
			</tr>
			<tr>
				<th>手机号</th>
				<td><input type="text" name="tel" id="" value="<?php echo $data1['tel'];?>"></td>
			</tr>
			<tr>
				<th></th>
				<td><input type="submit" value="修改"></td>
			</tr>
		</table>
	</form>
</body>
</html>	
```

接下来，处理用户修改提交的数据，添加update.php

```php
//edit.php

<?php 
include "./connect.php";
// var_dump($link);
$sql = 'select * from my_class';
$results = mysql_query($sql);
// var_dump($results);
// var_dump(mysql_error());
mysql_num_rows($results) > 0 or die('没有查询到数据');
$data = [];
while($row = mysql_fetch_assoc($results)){
	$data[] = $row;
}
// print_r($data);

// print_r($_GET);
if(!empty($_GET)){
	$stu_id = $_GET['stu_id'];
}else{
	$stu_id = 1;
}
// echo $stu_id;
$sql1 = 'select * from my_stu where stu_id='.$stu_id;
$results1 = mysql_query($sql1);
mysql_num_rows($results1) > 0 or die('暂无数据');
$data1 = mysql_fetch_assoc($results1);
print_r($data1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<!-- 录入学生的学号、姓名、年龄、性别，班级、手机号、电子照片等。 -->
	<form action="update.php" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="stu_id" value="<?php echo $data1['stu_id'];?>">
		<table width="60%" cellpadding="8" border="1" rules="all" align="center">
			<caption><h2>修改学生信息</h2></caption>
			<tr>
				<th>学生姓名</th>
				<td><input type="text" name="stu_name" id="" value="<?php echo $data1['stu_name'];?>"></td>
			</tr>
			<tr>
				<th>年龄</th>
				<td><input type="text" name="age" id="" value="<?php echo $data1['age'];?>"></td>
			</tr>
			<tr>
				<th>性别</th>
				<td>
					<input type="radio" name="sex" id="" value="男" <?php echo $data1['sex']=='男'?'checked':'';?>>男
					<input type="radio" name="sex" id="" value="女" <?php echo $data1['sex']=='女'?'checked':'';?>>女
					<input type="radio" name="sex" id="" value="保密" <?php echo $data1['sex']=='保密'?'checked':'';?>>保密
				</td>
			</tr>
			<tr>
				<th>班级</th>
				<td>
                    <select name="class_id" id="">
						<?php for($i=0;$i<count($data);$i++){?>						
                        	<option value="<?php echo $data[$i]['class_id']?>" <?php echo $data1['class_id']==$data[$i]['class_id']?'selected':'';?>><?php echo $data[$i]['class_name'] ?></option>
						<?php } ?>
					</select></td>
			</tr>
			<tr>
				<th>手机号</th>
				<td><input type="text" name="tel" id="" value="<?php echo $data1['tel'];?>"></td>
			</tr>
			<tr>
				<th></th>
				<td><input type="submit" value="修改"></td>
			</tr>
		</table>
	</form>
</body>
</html>	


```

```php
//update.php
<?php 
header('content-type:text/html;charset=utf8');
// print_r($_POST);
$stu_id = $_POST['stu_id'];
$stu_name = $_POST['stu_name'];
$age = $_POST['age'];
$sex = $_POST['class_id'];
$tel = $_POST['tel'];

?>
```

构建update SQL语句

```php
<?php 
header('content-type:text/html;charset=utf8');
include './connect.php';
// print_r($_POST);
$stu_id = $_POST['stu_id'];
$stu_name = $_POST['stu_name'];
$age = $_POST['age'];
$sex = $_POST['class_id'];
$tel = $_POST['tel'];

$sql = "update my_stu set stu_name = '$stu_name',age=$age,sex='$sex',tel = '$tel' where stu_id = $stu_id";
echo $sql;
$results = mysql_query($sql);
// var_dump($results);
if($results == true){
    echo '成功';
}else{
    echo '失败';
}
?>
```

跳转到首页
```php
<?php 
header('content-type:text/html;charset=utf8');
include './connect.php';
// print_r($_POST);
$stu_id = $_POST['stu_id'];
$stu_name = $_POST['stu_name'];
$age = $_POST['age'];
$sex = $_POST['class_id'];
$tel = $_POST['tel'];

$sql = "update my_stu set stu_name = '$stu_name',age=$age,sex='$sex',tel = '$tel' where stu_id = $stu_id";
echo $sql;
$results = mysql_query($sql);
// var_dump($results);
if($results == true){
    // echo '成功';
    header('location:./index.php');
}else{
    echo '失败';
}
?>
```

### 第七步 学生信息详情
修改index.php

```html
<td><a href="./detail.php?stu_id=<?php echo $data[$i]['stu_id'] ?>"><?php echo $data[$i]['stu_name'] ?></a></td>
```

在detail.php中接收数据

```php
<?php 
print_r($_GET);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>首页</title>
</head>
<body>
	<table width="50%" border="1" rules="all" cellpadding="8" align="center">
		<caption><h2>欧阳帅帅的信息</h2></caption>
		<tr>
			<th>学号</th>
			<td>1</td>
		</tr>
		<tr>
			<th>班级</th>
			<td>北京前端1</td>
		</tr>
		<tr>
			<th>学生照片</th>
			<td><img src="./upload/1.png" alt="" width='200'></td>
		</tr>

	</table>
</body>
</html>
```

接下来，我们通过id去查询数据，渲染到页面上来

```php
<?php 
// print_r($_GET);
include './connect.php';
if(empty($_GET)){
	$stu_id = 1;
}else{
	$stu_id = $_GET['stu_id'];
}
$sql = 'select * from my_stu where stu_id = '.$stu_id;
$results = mysql_query($sql);
$data = mysql_fetch_assoc($results);
print_r($data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>首页</title>
</head>
<body>
	<table width="50%" border="1" rules="all" cellpadding="8" align="center">
		<caption><h2><?php echo $data['stu_name'] ?>的信息</h2></caption>
		<tr>
			<th>学号</th>
			<td><?php echo $data['stu_id'] ?></td>
		</tr>
		<tr>
			<th>班级</th>
			<td><?php echo $data['class_id'] ?></td>
		</tr>
		<tr>
			<th>学生照片</th>
			<td><img src="<?php echo $data['pics'] ?>" alt="" width='200'></td>
		</tr>

	</table>
</body>
</html>
```

根据class_id去查询对应的班级

```php
<?php 
// print_r($_GET);
include './connect.php';
if(empty($_GET)){
	$stu_id = 1;
}else{
	$stu_id = $_GET['stu_id'];
}
$sql = 'select * from my_stu where stu_id = '.$stu_id;
$results = mysql_query($sql);
$data = mysql_fetch_assoc($results);
print_r($data);
$class_id = $data['class_id'];
$sql1 = 'select * from my_class where class_id='.$class_id;
$results1 = mysql_query($sql1);
$data1 = mysql_fetch_assoc($results1);
print_r($data1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>首页</title>
</head>
<body>
	<table width="50%" border="1" rules="all" cellpadding="8" align="center">
		<caption><h2><?php echo $data['stu_name'] ?>的信息</h2></caption>
		<tr>
			<th>学号</th>
			<td><?php echo $data['stu_id'] ?></td>
		</tr>
		<tr>
			<th>班级</th>
			<td><?php echo $data1['class_name'] ?></td>
		</tr>
		<tr>
			<th>学生照片</th>
			<td><img src="<?php echo $data['pics'] ?>" alt="" width='200'></td>
		</tr>

	</table>
</body>
</html>
```

- todo
	+ 可以搞一个定时器效果，让跳转用户体验更好一点
	+ 封装是为了让我们重复的代码只写一份。在封装的时候需要考虑的事情是，这个所封装的方法是有可能在各个地方被调用的，所以要考虑什么是变的，将变的东西放到参数中。

## 从详情页大家可以体会到
- 动态网站的本质，是什么造成了同一个文件内容显示不一样 ---> 参数不同

## 练习
- 安装edit this cookie chrome 插件