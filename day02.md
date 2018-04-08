## 重难点
- php中的+号就是加号，没有拼接的意思
- js中的if...else if...在php中变成了if...elseif...
- die函数的作用
- sleep函数的作用
- or的短路操作用途
- 函数作用域和全局作用域互相不能通信 
- 要记的函数 
    1. mt_rand
    2. date
    3. time

## 类型自动转换与强制类型转(14:39)

### 注意事项
- 在php中+号就是加号并没有拼接的功能

### 隐式类型转换
- 任何变量类型进行加减乘除操作，都会转换成数字类型

```php
echo 0+'aaa12345';//不是以数字开头的，转换成0
echo '<br>';
echo '<br>';
echo 1 + 'abc';
echo 0+'123aaa';//以数字开头的，截取前面的作为数字
echo '<br>';
echo 1 + '5.53string';
echo '<br>';
echo 5 + '-4string';
echo '<br>';
echo 1 + true;//true转换成1
echo '<br>';
echo 1 + false;//false转换成0
echo '<br>';
echo 1.5 + true;
echo '<br>';
echo 1 + null;//null转换成0
echo '<br>';

```

### 强制类型转换

```php
var_dump((int)('aaa12345'));//类似parseInt
echo '<br>';
var_dump((int)('123aaa'));
echo '<br>';
var_dump((int)('5.53string'));
echo '<br>';
var_dump((float)('5.53string'));//类似parseFloat
echo '<br>';
var_dump((int)(true));
echo '<br>';
var_dump((int)(false));
echo '<br>';
var_dump((int)(null));
```
a)转换为false的情况：(大家有没有感觉其实和empty函数类似????)
- 整型0
- 浮点型0.0
- 字符串’0’
- 空字符串 ‘’
- null
- 空数组

```php
<?php 
header('content-type:text/html;charset=utf8;');
if(!null){
    echo 'null是false';
}
echo '<br>';
if(![]){
    echo '[]是false';
}
echo '<br>';
if(!''){
    echo "''是false";
}
echo '<br>';
if(!0){
    echo '0是false';
}
echo '<br>';
if(!0.0){
    echo '0.0是false';
}
```

## define、const及defined函数(12:49)
- 常量不是$开头
- 推荐常量用大写(以后大家见到大写的，不以$开头的，默认可以认为是常量)

```php
define('PI',3.14159);
echo PI;
echo '<br>';
const PI1 = 3.14159;
echo PI1;
echo '<br>';
var_dump(defined('PI'));
```

## 运算符(13:27)
- 错误抑制符
    + js如果出错了，会在控制台报错，普通用户看不到
    + php如果出错了，直接在客户端浏览器报错，普通用户看到了会不友好，所以如果不是特严重的可以抑制掉的
    + 可以用来抑制warnning、notice级别的错误，致命错误也不能抑制

```php
$a = 8;
$b = 0;
echo @($a / $b);//要学会看报错信息
```

- 拼接运算符

## 条件判断(21:05) - 不放
- js中的if...else if...在php中变成了if...elseif...
- &&作用和and作用是一样的 
- ||与or作用是一样的

```php
var_dump(true || false);
echo '<br>';
var_dump(true or false);
echo '<br>';
var_dump(true && false);
echo '<br>';
var_dump(true and false);
```

- !代表非的意思

- die函数的作用 - 中止代码继续往后操作(了解：还有一个和它一样的叫exit）

```
<?php
header('content-type:text/html;charset=utf8');
$host = 'localhost';//数据库服务器主机名
$user = 'root';//数据库服务器用户名
$password = 'root';//密码
//与数据库建立连接，成功返回资源类型数据，失败返回FALSE,类似和别人聊天先要打电话把电话打通建立连接
$link = @mysql_connect($host,$user); 
$db = 'ceshi1';
@mysql_query('use '.$db);
?>
```

- 上面写法太麻烦了，可以利用php的or的特点(如果前面是true,后面半句不会执行) ---> 短路机制

```php
<?php
header('content-type:text/html;charset=utf8');
$host = 'localhost';//数据库服务器主机名
$user = 'root';//数据库服务器用户名
$password = 'root';//密码
//与数据库建立连接，成功返回资源类型数据，失败返回FALSE,类似和别人聊天先要打电话把电话打通建立连接
$link = @mysql_connect($host,$user); 
$db = 'ceshi1';
@mysql_query('use '.$db) or die('数据库连接失败');
?>
```


```php
if(!defined('PI')){
    define('PI',3.14159);
}
```

简写如下：

```php
//短路运算：如果前面的值是true,则后面的表达式不执行，相当于被抛弃
//如果前面的是false,则后面的表达式执行
defined('PI') or define('PI',3.14159);
```

## 循环 - 不放
- sleep()

```php
$a = 100;
sleep(5);//一般用于模拟网络延迟效果，网速比较慢的效果
echo $a;
```

## 函数基础语法(23:09)(不放)
- 优秀的程序员哪怕是设计一个炸毁火星的函数，肯定不是直接写一个function,而是设计一个参数，然后把火星当参数传进去

- 参数默认值

```php
function add($a,$b){
    return $a + $b;
}
echo add(2,3);
```

如果用户传入的参数个数不够，会有警告信息

```php
function add($a,$b){
    return $a + $b;
}
echo add(2);
```

解决办法：参数默认值

```php
function add($a=0,$b=0){
    return $a + $b;
}
echo add(2);
```

## 作用域(20:00)
- 全局变量(函数外定义的变量)
- 函数内部变量
- 函数内部不能访问函数外面的变量
- 超全局变量$GLOBALS
    1. 创建的全局变量，系统会自动在$GLOBALS中创建变量名为下标的元素
    2. 在$GLOBALS中添加元素，自动创建相应名字的全局变量
    3. 删除或者修改$GLOBALS数组的元素，会导致全局变量同步修改或删除

![](./scope.png)

## 系统函数(16:41)

### 数字相关

```php
header('content-type:text/html;charset=utf8;');
echo max(4,1,3);
echo '<br>';
echo min(4,1,3);
echo '<br>';
echo round(5.5);
echo '<br>';
echo ceil(5.5);
echo '<br>';
echo floor(5.5);
echo '<br>';
echo rand(1,100);
echo '<br>';
echo mt_rand(1,100);//mt_rand()是更好地随机数生成器，因为它跟rand()相比播下了一个更好地随机数种子；而且性能上比rand()更好
echo mt_rand(1000,9999);
```

- max 类似js中的Math.max
- min 类似js中的Math.min
- abs 类似js中的Math.abs
- floor 类似js中的Math.floor
- ceil 类似js中的Math.ceil
- round 类似js中的Math.round
- rand和mt_rand(区别：mt_rand性能更快) 类似js中的Math.random

### 日期相关

```php
header('content-type:text/html;charset=utf8;');
echo date('Y-m-d H:i:s');// 相当于js中的(new Date()).toString() Y-m-d H:i:s ---> 年-月-日 时:分:秒 参考：http://www.php.net/manual/zh/function.date.php 通过手册上的说明，大家可以明白为什么Y,H必须要是大写的
echo '<br>';
//重点是YmdHis，中间的是分割符，为了好看而加上去的
echo date('Y年m月d日 H时i分s秒');
echo '<br>';
echo '时间戳'.time();//和js的区别：js的时间戳（Date.now()）位数是14位，单位是微秒，php的时间戳单位是秒
echo '<br>;
echo strtotime('+1 day);//1521724548,(new Date(1521724548 * 1000))
echo '<br>';
echo date('Y-m-d H:i:s',strtotime('+1 day'));//明天当前这个点的时间是多少 http://php.net/manual/zh/function.strtotime.php
```

```php
//从 Unix 纪元（格林威治时间 1970-01-01 00:00:00）到当前时间的秒数
time()
```

### strtotime的用法(了解)

```php
echo strtotime('now'),"\n";
echo strtotime("10 September 2000"),"\n";
echo strtotime("+1 day"),"\n";
echo strtotime("+1 week"),"\n";
echo strtotime("next Thursday"),"\n";
echo strtotime("last Monday"),"\n";
```

## 文件引入(24:30)
- 理解，我们平时写代码的时候或多或少会想到，有些东西是在重复，我们能不能提取出来呢?
- include:如果重复引入同一个文件，会执行多次
- include_once:如果重复引入同一个文件，只会执行一次
- require:如果重复引入同一个文件，会执行多次
- require_once:如果重复引入同一个文件，只会执行一次

- include和require的区别：include如果引入一个不存在的文件，会有警告信息，但不影响代码往下执行，require如果引入一个不存在的文件，直接产生致命的错误

### 如何取舍

大部分情况下是没啥区别的，大家随便用就可以了

比如是系统配置，缺少了，网站不让运行，自然用require，如果是某一段统计程序，少了，对网站只是少统计人数罢了，不是必须要的，可以用include 

如果你当前的文件是定义了几个变量，而不加once，因为这样会重复定义，浪费性能


四种方式的对比：

|                    | require | require_once | include | include_once |
| ------------------ | ------- | ------------ | ------- | ------------ |
| 被载入文件如果不存在是否影响继续运行 | Y       | Y            | N       | N            |
| 多次调用是否会重复执行被载入的文件  | Y       | N            | Y       | N            |

总结来说：

- 横向分为两类：require 和 include 两种，区别在于 require 会因为载入文件不存在而停止当前文件执行，而 include 不会。
- 纵向分为两类：xxx 和 xxx_once，区别在于代码中每使用一次 xxx 就执行一次载入的文件，而 xxx_once 只会在第一次使用是执行。

使用层面：

- include 一般用于载入公共文件，这个文件的存在与否不能影响程序后面的运行
- require 用于载入不可缺失的文件
- 至于是否采用一次载入（once）这种方式取决于被载入的文件


### 路径问题(对非php专业的我们来说了解即可，基本上用不上)
- 相对路径存在的问题：(ceshi目录用来说明这个问题的)
    + http://www.ali.com/ceshi/b/b.php访问这个路径是没问题的
    + 但是访问http://www.ali.com/ceshi/ceshi.php就会出问题
    + 原因：php 默认相对路径都是以被访问页面所在路径为准的。无论一个入口页面，里面包含多少文件，相对路径，都是以这个页面为准。
    + 大家可以测试一下，在ceshi目录外面建一个a目录，在里面建一个a.php,这时候会发现不会报错的
- 使用绝对路径 ---> 不靠谱，比如你的代码是在D盘写的，别人拷贝你的代码之后，结果发现，代码是拷贝在其他盘，就会出问题
- 解决方案：用魔术常量__DIR__（代码可以参考ceshi_使用__DIR__）

### 扩展

![](./文件包含.png)

## 练习
- 把后天的当前时间打印出来
- 打印1-100的偶数(提示：用循环+条件判断来实现)
- 实现两个数的加减乘除运算，并利用require或include提取到一个单独的文件当中，并且解释用include,include_once,require,require_once中的哪一个最合适
- 用php实现冒泡排序(提高题，选做)
- 写2个函数，分别可以求得两个正整数的最大公约数和最小公倍数。(和数学相关，大家选做)
    + 最大公约数就是能够同时整除该两个数的最大的那个。比如24和36的最大公约数是12
    + 最小公倍数就是能够同时被该两个数整除的最小的那个。比如24和36的最小公倍数是72
- 写一个函数，该函数能够判断一个数字是否是一个素数（是就返回true，否则就返回false）。再利用该函数，输出2-200之间的所有素数。(和数学相关，大家选做)
    + 提示：素数的概念（含义）是：只能被1和它自己本身整除——在大于1的整数范围内。
- 阿里百秀项目后台左侧导航提取出来(admin/include/aside.php)

## 练习参考答案最小公倍数就是能够同时被该两个数整除的最小的那个。比如24和36的最小公倍数是72
- 写一个函数，该函数能够判断一个数字是否是一个素数（是就返回true，否则就返回false）。再利用该函数，输出2-200之间的所有素数。



```php
echo date('Y-m-d H:i:s',strtotime('+2 day'));
```

```php
for($i=0;$i<=100;$i++){
    if($i%2==0){
        echo $i;
        echo '<br>';
    }
}
```

```php

<?php 
//add.php
function add($a,$b){
    return $a + $b;
}
?>


<?php
//substract.php 
function substract($a,$b){
    return $a - $b;
}
?>

<?php
//multiply.php 
function multiply($a,$b){
    return $a * $b;
}
?>

<?php 
function divide($a,$b){
    return $a / $b;
}
?>

<?php
/**
 * 分析：
 * 我们下面要用到计算的方法，如果引入失败，再往下做没有意义，所以考虑用require_once或require
 * 为了执行效率，可以考虑使用require
 * 
 */

 require('./add.php');
 require('./substract.php');
 require('./multiply.php');
 require('./divide.php');
 echo add(2,3);
 ?>
 ```

```php
<?php
//首先，大家思考一下，如何交换两个值
$a = 3;
$b = 2;
//交换
if($a > $b){
    $temp = $a;
    $a = $b;
    $b = $temp;
}

echo $a.' '.$b;


//接下来，我们有一个数组，我们想让第一个数是最小的数
<?php 
$arr =  [3,1,10,5,11,12,6];
$j = 0;
for($i=$j+1;$i<count($arr);$i++){
    if($arr[$i] < $arr[$j]){
        $temp = $arr[$i];
        $arr[$i] = $arr[$j];
        $arr[$j] = $temp;
    }
}
print_r($arr);

//接着，我们再把第二项，与剩下的进行比较，这样直到比较到倒数第二项，我们的排序就完成了
<?php 
$arr =  [3,1,10,5,11,12,6];
for($j=0;$j<count($arr)-1;$j++){
    for($i=$j+1;$i<count($arr);$i++){
        if($arr[$i] < $arr[$j]){
            $temp = $arr[$i];
            $arr[$i] = $arr[$j];
            $arr[$j] = $temp;
        }
    }
}
print_r($arr);
//到这儿，咱们这道题就完成了
?>
```

## 扩展 - html混写 - 为day06的例子做准备

```php
<p><?php echo 'hello'; ?></p>
```

```php
<?php if ($age >= 18) { ?>
  <p>成年人</p>
<?php } else { ?>
  <p>小朋友</p>
<?php } ?>
```

```php
<?php if ($age > 18): ?>
  <p>成年人</p>
<?php else: ?>
  <p>小朋友</p>
<?php endif ?>
```


```php
<?php 
$data = [
    [
        "id"=>1,
        "cid"=>1,
        "name"=>"ipad mini",
        "price"=>1000
    ],
    [
        "id"=>2,
        "cid"=>2,
        "name"=>"macbook",
        "price"=>9000
    ],
    [
        "id"=>3,
        "cid"=>1,
        "name"=>"ipad 2",
        "price"=>4000
    ],
    [
        "id"=>4,
        "cid"=>2,
        "name"=>"iphone 6s",
        "price"=>3600
    ]
];
// print_r($data);
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
    <table border="1" rules="all" width="60%" align="center" cellpadding="8">
		<caption><h2>电子设备</h2></caption>
		<tr>
			<th>编号</th>
			<th>名称</th>
			<th>价格</th>
        </tr>
        <?php for($i=0;$i<count($data);$i++){?>
		<tr align="center">
			<td><?php echo $data[$i]['id']?></td>
			<td><?php echo $data[$i]['name']?></td>
			<td><?php echo $data[$i]['price']?></td>
        </tr>
        <?php }?>
	</table>
</body>
</html>
```
