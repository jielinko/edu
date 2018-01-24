ThinkPHP 5.0入门实例教程
===============



[《ThinkPHP5.0入门实例教程》](https://www.kancloud.cn/yunzhiclub/thinkphp5guide) 是由河北工业大学梦云智团队开发的一款Tp5教程, 本代码是本人在学习的时候根据教程完善后的版本, 供其他小伙伴学习参考, 版权归梦云智团队所有.

本教程开发了一款『教务管理』系统。通过对该小型系统的开发，我们将了解ThinkPHP5是如何协助我们来开发具体项目的。

本系统包括登录与注销、教师管理、班级管理、学生管理和课程管理等功能模块。

通过对本教程的学习，我们将：对入口文件、模块、控制器、触发器、命名空间、E-R图等基本知识有所掌握；对面向对象的编程方法有更深入的了解与掌握；对如何使用ThinkPHP5来开发中小型系统有了更深入的认识；能够使用ThinkPHP开发小型系统。


## 重构前目录结构

初始的目录结构如下：

~~~
www  WEB部署目录（或者子目录）

├── application
│   ├── common
│   │   ├── model
│   │   │   ├── Course.php
│   │   │   ├── Klass.php
│   │   │   ├── KlassCourse.php
│   │   │   ├── Student.php
│   │   │   └── Teacher.php
│   │   └── validate
│   │       ├── Course.php
│   │       ├── Klass.php
│   │       ├── KlassCourse.php
│   │       ├── Student.php
│   │       └── Teacher.php
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
│   │       │   ├── add.html
│   │       │   ├── edit.html
│   │       │   └── index.html
│   │       ├── Klass
│   │       │   ├── add.html
│   │       │   ├── edit.html
│   │       │   └── index.html
│   │       ├── Login
│   │       │   └── index.html
│   │       ├── Student
│   │       │   ├── add.html
│   │       │   ├── edit.html
│   │       │   └── index.html
│   │       └── Teacher
│   │           ├── add.html
│   │           ├── edit.html
│   │           └── index.html
│   ├── command.php
│ 	├── common.php
│   ├── config.php
│   ├── database.php
│   ├── route.php
│   └── tags.php

### 教师表密码生成算法

```
sha1(md5($password).'salt');

“123456”->“5f67ea9991744a45432175cac508884ddc23b1c8”
```

