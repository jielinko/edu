《ThinkPHP 5.0入门实例教程》重构后源码
===============



[《ThinkPHP5.0入门实例教程》](https://www.kancloud.cn/yunzhiclub/thinkphp5guide) 是由河北工业大学梦云智团队开发的一款Tp5教程。

本代码是本人在学习完该教程以后完善后的版本, 供其他小伙伴学习参考, 版权归梦云智团队所有。

本系统包括登录与注销、教师管理、班级管理、学生管理和课程管理等功能模块。

>后续会添加RBAC权限控制模块并加以完善成为一个实用的管理系统。

## 重构后目录结构

目录结构如下：

~~~
www  WEB部署目录（或者子目录）
├── application
│   ├── command.php
│   ├── common
│   │   ├── model
│   │   │   ├── Course.php
│   │   │   ├── Klass.php
│   │   │   ├── KlassCourse.php
│   │   │   ├── Msg.php
│   │   │   ├── Student.php
│   │   │   └── Teacher.php
│   │   └── validate
│   │       ├── Course.php
│   │       ├── Klass.php
│   │       ├── KlassCourse.php
│   │       ├── Student.php
│   │       └── Teacher.php
│   ├── common.php
│   ├── config.php
│   ├── database.php
│   ├── index
│   │   ├── controller
│   │   │   ├── CourseController.php
│   │   │   ├── IndexController.php
│   │   │   ├── KlassController.php
│   │   │   ├── LoginController.php
│   │   │   ├── StudentController.php
│   │   │   ├── TeacherController.php
│   │   │   └── TestController.php
│   │   └── view
│   │       ├── Course
│   │       │   ├── edit.html
│   │       │   └── index.html
│   │       ├── Klass
│   │       │   ├── edit.html
│   │       │   └── index.html
│   │       ├── Login
│   │       │   └── index.html
│   │       ├── Student
│   │       │   ├── edit.html
│   │       │   └── index.html
│   │       ├── Teacher
│   │       │   ├── edit.html
│   │       │   └── index.html
│   │       ├── edit.html
│   │       └── index.html
│   ├── route.php
│   └── tags.php

~~~

### 系统登录

>使用教师表任一用户进行登录

如: zhangwu/123456

>教师表密码生成算法

```
sha1(md5($password).'salt');

“123456”->“5f67ea9991744a45432175cac508884ddc23b1c8”
```

### 界面显示

#### 教师管理界面
![教师信息管理](http://jielinko-develop.oss-cn-shenzhen.aliyuncs.com/18-1-28/24990885.jpg)

#### 学生管理界面
![](http://jielinko-develop.oss-cn-shenzhen.aliyuncs.com/18-1-28/3962202.jpg)

##### 编辑学生信息
![](http://jielinko-develop.oss-cn-shenzhen.aliyuncs.com/18-1-28/84022892.jpg)

#### 班级管理界面
![](http://jielinko-develop.oss-cn-shenzhen.aliyuncs.com/18-1-28/71214732.jpg)

#### 课程管理界面
![](http://jielinko-develop.oss-cn-shenzhen.aliyuncs.com/18-1-28/2795409.jpg)

##### 添加课程信息
![](http://jielinko-develop.oss-cn-shenzhen.aliyuncs.com/18-1-28/44739943.jpg)

