## 字符串使用(20:05)
- 单引号规则
    + 单引号中使用变量并不会被解析
    + 单引号中套单引号要转义
    + 单引号中套双引号变量并不会被解析
- 双引号规则
    + 双引号中使用变量会被解析
    + 双引号中可以解析识别转义字符` \ $ \r \n \t`
    + 双引号中套双引号要转义
    + 双引号中套单引号也会解析
    + 为了防止变量解析错误，可以在变量外面套一个花括号
- 如何使用
    + 如果想解析变量，最外层一定要用双引号



```php
<?php 
header("content-type:text/html;charset=utf8");
$str = "前端移动开发";
$str2 = '最喜欢的专业是$str <br>';
$str3 = "最喜欢的专业是$str <br>";
echo $str2;
echo $str3;
?>
```

```php
<?php
// ====== 单引号 ======
echo 'hello\nworld';
// => `hello\nworld`
echo 'I\'m a better man';
// => `I'm a better man`
echo 'OS path: C:\\Windows';
// => `OS path: C:\Windows`

// ====== 双引号 ======
echo "hello\nworld";
// => `hello
// world`
$name = 'zce';
echo "hello $name";
// => `hello zce`
```

- heredoc
    + 好处就是可以换行，保持要打印的字符的结构

```php
<?php 
header('content-type:text/html;charset=utf8;');
$str = <<<AAA
    <div>
        <h3>标题</h3>
        <p>我是内容</p>
    </div>
AAA;
echo $str;
?>
```

注意：第一个定界符后面不能有空格，否则会报错

- strlen,mb_strlen函数

```php
<?php 
header('content-type:text/html;charset=utf8;');
$str = '中国';
echo strlen($str);
echo '<br>';
echo mb_strlen($str,'utf-8');
?>
```

## 字符串函数（上）(25:33)
- http://php.net/manual/zh/ref.strings.php
- http://www.w3school.com.cn/php/php_string.asp
- printf
    + %s
    + %d
    + %f 

解决的问题：
```php
<?php 
header('content-type:text/html;charset=utf8;');
$str = 'hello';
$str1 = 'world';
$num = 100;
$num1 = 200;
echo $str.' '.$str1.' '.($num * $num1);
?>
```

大家会发现上面的字符串拼接比较丑陋
我们可以考虑用printf来改写

```php
<?php 
header('content-type:text/html;charset=utf8;');
$str = 'hello';
$str1 = 'world';
$num = 100;
$num1 = 200;
printf('%s %s %d',$str,$str1,$num * $num1);//%d 十进制有符号整数 %s:字符串 占位符和要打印的数据是一一对应的

?>
```

- str_replace

```php
<?php 
header('content-type:text/html;charset=utf8;');
echo str_replace('abc','666','awfwefabcojiowef');
?>
```

- str_repeat

```php
<?php 
header('content-type:text/html;charset=utf8;');
echo str_repeat('abc',100);
?>
```

- strtolower

```php
<?php 
header('content-type:text/html;charset=utf8;');
echo strtolower('HelloWorld');
?>
```

- strtoupper

```php
<?php 
header('content-type:text/html;charset=utf8;');
echo strtoupper('HelloWorld');
?>
```

- ucfirst

```php
<?php 
header('content-type:text/html;charset=utf8;');
echo ucfirst('hello world');
?>
```

- trim,ltrim,rtrim

```php
<?php 
header('content-type:text/html;charset=utf8;');
$str = '   hello   world    ';
echo strlen($str);
echo '<br>';
$str1 = trim($str);
echo strlen($str1);
echo '<br>';
$str2 = ltrim($str);
echo strlen($str2);
echo '<br>';
$str3 = rtrim($str);
echo strlen($str3);
?>
```

- explode(类似js中的split函数)

```php
<?php 
header('content-type:text/html;charset=utf8;');
$str = 'h-e-l-l-o-w-o-r-l-d';
$arr = explode('-',$str);
print_r($arr);
?>
```

- implode 
    + 类似js中的join

```php
<?php 
header('content-type:text/html;charset=utf8;');
$arr = ['h','e','l','l','o','w','o','r','l','d'];
echo implode('-',$arr);
?>
```

- str_split
    + 类似js中的split，默认是拆成一个字符，可以指定按几个字符进行拆分

```php
<?php 
header('content-type:text/html;charset=utf8;');
$str = 'abcdefg';
$arr = str_split($str,3);
print_r($arr);
echo '<br>';
$arr1 = str_split($str,4);
print_r($arr1);
?>
```

- strpos
    + 类似js中的indexOf

```php
<?php 
header('content-type:text/html;charset=utf8;');
$str = "abc.php.php";
echo strpos($str,'.php');//第一个.php的索引
?>
```

- strrpos 查找字符串在另一字符串中最后一次出现的位置。

```php
<?php 
header('content-type:text/html;charset=utf8;');
$str = "abc.php.php";
echo strrpos($str,'.php');//第一个.php的索引
?>
```

- substr

```php
<?php 
header('content-type:text/html;charset=utf8;');
$str = 'abc.php.js';
$rindex = strrpos($str,'.');//找出最右边的点的位置，确定扩展名
echo '扩展名为'.(substr($str,$rindex));
?>
```

上面这个为了得到扩展名，太麻烦了 ---> 


```php
<?php 
header('content-type:text/html;charset=utf8;');
$str = 'abc.php.js';
echo '扩展名为'.(strrchr($str,'.'));//strrchr() 函数查找字符串在另一个字符串中最后一次出现的位置，并返回从该位置到字符串结尾的所有字符。
?>
```

和上面很像的有strchr,查找字符串在另一个字符串中第一次出现的位置，并返回从该位置到字符串结尾的所有字符。

```php
<?php 
header('content-type:text/html;charset=utf8;');
$str = 'abc.php.js';
echo '扩展名为'.(strchr($str,'.'));
?>
```


- 转义字符
- \n 换行
- \r 回车
- \r\n 回车换行
- \t 制表符
- \’ 单引号
- \” 双引号
- \$ 美元标记
- 转义字符只有在双引号或heredoc中才能识别

## 数组入门(16:09)
- 显式创建数组

```php
$arr = [1,3,4];
print_r($arr);
```

- 隐式创建数组

```php
$arr[] = 123;
$arr[] = 4565;
print_r($arr);
```

- 数组的类型
    + 索引数组 --> js中的数组 
    + 关联数组 --> js中的不包含方法的对象(只有属性的对象) 

```php
<?php
// 定义一个索引数组
$arr = array(1, 2, 3, 4, 5);
var_dump($arr);

// PHP 5.4 以后定义的方式可以用 `[]`
$arr2 = [1, 2, 3, 4, 5];
var_dump($arr2);
```

```php
<?php
// 注意：键只能是`integer`或者`string`
$arr = array('key1' => 'value1', 'key2' => 'value2');
var_dump($arr);

// PHP 5.4 以后定义的方式可以用 `[]`
$arr2 = ['key1' => 'value1', 'key2' => 'value2'];
var_dump($arr2);
```


```php
<?php 
header('content-type:text/html;charset=utf8;');
//索引数组 --> 类似js中的数组
$arr1 = [2,3,4];
for($i=0;$i<count($arr1);$i++){
    echo $arr1[$i];
    echo '<br>';
}
//关联数组 --> 类似js中的对象,foreach和js中的forEach意思是一样的，大家不要觉得是新东西
$arr2 = ['name'=>'小明','age'=>20];
foreach ($arr2 as $value) {
    echo $value;
    echo '<br>';
}

//关联数组 遍历键和值
foreach ($arr2 as $key => $value) {
    echo '值为'.$value;
    echo '<br>';
    echo '键为'.$key;
    echo '<br>';
}
?>
```


## 数组遍历语法(17:38)
- 如上代码

## 数组函数（上）(26:54)
- max
- min
- count
- in_array
- range
- array_merge
- array_rand
- shuffle
- array_keys
- array_values
- sort
- asort
- ksort
- arsort
- krsort

```php
<?php
header('content-type:text/html;charset=utf8');
$arr1 = [4,1,2,9,3];
echo '最大值为'.max($arr1);
echo '<br>';
echo '最小值为'.min($arr1);
echo '<br>';
echo '数组的个数为'.count($arr1);
echo '<br>';
echo var_dump(in_array(4,$arr1));//判断4是否在这个数组中
echo '<br>';
print_r(range(1,10));//随机生成1到1-10的数 range(起始元素，终止元素[，步长=1])
echo '<br>';
$arr2 = [4,5,6];
print_r(array_merge($arr1,$arr2));合并数组
echo '<br>';
print_r(array_rand($arr1,3));//随机取出来3个
echo '<br>';
shuffle($arr1);//打乱数组，增加数组元素的随机性。
print_r($arr1);
echo '<br>';
print_r(array_keys($arr1));
echo '<br>';
print_r(array_values($arr1));
echo '<br>';
sort($arr1);//对数组元素进行升序排序，重建数字索引。
print_r($arr1);
echo '<br>';
$arr1 = [4,1,2,9,3];
asort($arr1);//对数组元素进行升序排序，保持索引（a, Associative Array，关联数组）
print_r($arr1);
echo '<br>';
$arr1 = [4,1,2,9,3];
rsort($arr1);//对数组元素进行降序排列(r,reverse,逆向)，重建索引。
print_r($arr1);
echo '<br>';
$arr1 = [4,1,2,9,3];
arsort($arr1);//对数组元素进行降序排列，保持索引。
print_r($arr1);
$arr3 = ['b'=>'测试1','a'=>'测试2','m'=>'测试3'];
ksort($arr3);//	按照键名（key）升序排序，主要用于关联数组。保存数组的索引
print_r($arr3);
echo '<br>';
$arr3 = ['b'=>'测试1','a'=>'测试2','m'=>'测试3'];
krsort($arr3);//	按照键名降序排序，主要用于关联数组。保存数组的索引。
print_r($arr3);
```

## 数组函数（下）(14:07)

## 数据库介绍(18:08)
0. 感性的认知数据库
    + 一个班的人这么多，刚开始的时候互相不认识，需要把所有的人的信息进行统计汇总放入一个excel文件当中
        1. 名册表
        2. 成绩表
        3. 就业城市意向表
    + 数据库无处不在
        1. 买票
        2. 游戏玩家数据
        3. 淘宝商品、用户数据
        4. 手机通讯录
        5. ...
    + 常见数据库类型：oracle,sql server,mysql,mongodb
    + excel文件 --> 数据库 database
    + 表 --> 表table
    + 记录 row,record
    + 字段 column,field

## SQL介绍(17:10)
- 命令行客户端如何连接数据库服务器
    1. 其他选项 --> mysql工具 --> mysql命令行
    2. 输入`root`,按回车
- SQL语句介绍
    + DDL,DML这些术语可以无视掉，没什么用处,大家主要能熟悉这些具体的SQL语句就可以了

```sql
//创建数据库tmall
create database tmall;
```

```sql
//使用tmall数据库
use tmall;
```

```sql
//在tmall数据库中创建一个user表
create table user(
    id int,
    name varchar(20)
);
```

```sql
//插入数据
insert into user values (1,"测试");
```

```sql
//查询user表中的数据
select * from user;
```

如果出现乱码：

```sql
set names gbk;
```

```sql
//修改数据
//字符串必须要用引号引起来
update user set name = "taylor swift" where id = 1;
```

### 注意事项
- 字符串必须要用引号引起来
- 只有最左边是`mysql>`这样子，才说明连接成功了，才能在里面输入sql语句
- 大部分sql语句是了解即可，后面会用图形化工具，大家不用太担心记不住
- 重点学习图形化工具的使用，以及部分需要掌握的SQL语句（后面会学习的）
- 大家大胆的操作数据库，如果玩坏了，大不了重装phpStudy即可

## 接下来学习navicat的用法
- 安装方式
    1. 先安装适配当前自己电脑的navicat软件
    2. 安装好了之后，先不要打开，先把PatchNavicat.exe补丁打一下
    3. 接下来就可以使用了

- 连接数据库

- 这块大家用命令行的原因是：为了对数据库更深的理解，后期我们会使用类似naticat一样的东西，好多命令其实没必要记的，核心要记的命令并不多
- mysql数据库


### 连接数据库的过程
1. 确保数据库服务器开启成功(观察MYSQL状态是不是绿色的)
2. 点击其他选择 --> mysql工具 --> mysql命令行 --> 输入密码 --> 回车
3. 设置命令行窗口的编码 : set names gbk

1. 通过访问我电脑上的数据库服务器来理解数据是放在数据库服务器上面的
2. 理解数据库服务器上面有很多的数据库，每个数据库类似一个excel文件
3. 手动创建数据库
    + 字符集：utf8 -- UTF-8 Unicode
    + 排序规则：ut8_general_ci

4. 手动创建表
5. 手动往表中添加数据
6. 为什么我们必须得学习SQL语句
    + 我们操作数据库中的数据，最终并不是人在操作，而是写好代码之后，交由代码去执行
7. 常见SQL语句
    + show databases; 查看当前数据库服务器有哪几个数据库
    + use 数据库名; 使用哪个数据库
    + show tables;查看当前选择使用的数据库有哪些 表
    + select 字段名 from 表名;
    + select * from 表名;
    + select count(*) from 表名;
    + select count(*) as 别名 from 表名;
    + select * from 表名 where id = 1;
    + insert into 表名 set 字段名 = 字段值...;(方式一)
    + insert into 表名(字段名...) values(字段值...),(字段值...)(方式二)
    + update 表名 set 字段名 = 字段值..
    + delete from 表名 where id = 1;
    + 规范
        1. 字符串必须要用引号引起来
        2. 不区分大小写
        3. 出错了，一定要把出错信息翻译一下


        


    



