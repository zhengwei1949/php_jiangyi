## 引言
- 我们前天做的案例：学生信息添加系统只做了一半，造出一个sql语句之后，接下来是我们人工的去数据库中去操作的，学完今天的东西之后，我们就可以把它完善

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



