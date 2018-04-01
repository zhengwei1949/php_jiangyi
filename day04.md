## 重难点
- 通过navicat建数据库、建表
- 高级查询语句
    + where 
    + group by 人以类聚 物以群分
    + limit 
- 连接查询
    + 小明是一班的，一班的班主任是李老师
    + 问题：小明的班主任是谁?
- 子查询

## 数据库操作（上）(20)
## 数据库操作（下）(8:35)
## 接下来我给大家讲如下几个知识点

## 必须掌握的SQL语句
- 今天学习可能会让大家很慌，要记的命令这么多，其实今天好多命令不需要记，因为好多命令在php代码中基本上不会用的，完全可以用图形化界面来操作替代，下面我罗列的是大家必须要掌握的一些，其他的了解即可
- set names utf8;//设置字符集
- use 数据库名;
- curd(insert,delete,update,select)，这是重点
    + 注册账号 : insert
    + 更新自己信息:update
    + 注销 : delete 
    + 查看东西：select
    + 看淘宝上卖什么:select 
- 字段类型(这块视频中讲得有点难，通过navicat进行学习，大的范围上来说，大家记住int,varchar,text即可，其他的可以用的时候再查)
    + char 定长字符串
    + varchar 不定长字符串，类如姓名
    + text 文章
    + int 整数
    + tinyint
    + float(7,2)代表的小数点2位，整数5位
    + decimal 货币等对精度有要求的
    + date 日期
- 字段属性(这块不用记，在图形化工具当中操作十分方便)
- where子句
- group by
- limit

## mysql语句练习.doc

## 数据库操作命令
- show databases; --> 查询数据库服务器中有多少个数据库
- show create databases 数据库名; --> 查询某数据库是怎么创建的
- create database huawei charset gbk; --> 创建数据库
- drop database 数据库名; --> 根据数据库名字删除数据库
- alter database 数据库名 charset utf8; --> 不要把alter和alert搞混了,一般只需要设置为utf8即可
- use 数据库名; --> 使用某数据库
- show tables; --> 查看当前数据库中的全部数据表
- desc 数据表名; --> 显示数据表结构信息 

## 字段类型 
- int (比tinyint大的数都用这个)
- tinyint (-128,127)
- float - decimal 对精度要求高用decimal,对精度要求低用float
- varchar 存比较长的字符串，需指定长度
- char
    + 手机号用char类型存，因为int（21亿）  占据4个字节的空间，存储有符号数（可存储负数）,手机号超过了范围存不下
- text 指定较长的字符串，无需指定字符串长度
- datetime 年月日时分秒
- date 年月日
- time 时分秒 

### 疑问：为什么搞一个int，还要搞一个tinyint,搞一个decimal,还要搞一个float
- 为了性能 
![](http://7fvanf.com1.z0.glb.clouddn.com/17-11-14/53188366.jpg)
![](http://7fvanf.com1.z0.glb.clouddn.com/17-11-14/14163909.jpg) 

## 字段限制
- null,not null 限定字段值不能为空
- default 设置字段的默认值，在没有录入时自动使用默认值填充
- primary key 主键(人的身份证一样，是唯一的，不能为空)
- auto_increment 自增长
- unique key 唯一
- comment 字段注释 

## 数据操作 
- C 增
- D 删
- U 改
- R 查 

## 查询高级操作

### 连接查询
- 也就是两张表在一起查 

### 子查询()
- 在查出一个大范围的数据之后，再在这个数据集里面筛选数据 

## 作业
使用mysql登录数据库系统，并创建一个数据库（db1），设置其编码为utf8。
再其中创建一个表demo，其中包括2种类型的字段：age int，name varchar
注意：varchar类型需要设定长度:varchar(长度);
往该表中插入几条数据，其中包括一些中文。
查出数据表demo中数据
更新一个字段的值
作业要求：在cmd窗口中完成操作成功并截图，放到一个Word文档