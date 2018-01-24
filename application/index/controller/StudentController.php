<?php
namespace app\index\controller;

use think\Request;
use app\common\model\Student;
use app\common\model\Klass;


class StudentController extends IndexController
{
    public function index()
    {
        $name = input('get.name');

        $pageSize = 2;

        $Student = new Student;

        // 按条件查询数据并调用分页
        $students = $Student->where('name','like','%'.$name.'%')->paginate($pageSize,false,[
            'query' => [
                'name' => $name, // query:url额外参数 将name值添加到后续页面url中
            ],
        ]);

        $this->assign('students', $students);
        return $this->fetch();
    }

    public function add()
    {
        try {
            // 获取所有的班级信息
            $klasses = Klass::all();
            $this->assign('klasses', $klasses);
            $htmls = $this->fetch();
            return $htmls;
        } catch (\Exception $e) {
            return '系统错误'.$e->getMessage();
        }
    }

    public function insert()
    {
        $message = '';

        try {
            // 接收传入数据
            $postData = Request::instance()->post();

            // 实例化Student空对象
            $Student = new Student();

            // 为对象赋值
            $Student->name = $postData['name'];
            $Student->num = $postData['num'];
            $Student->sex = $postData['sex'];
            $Student->klass_id = $postData['klass_id'];
            $Student->email = $postData['email'];

            // 新增学生对象至数据表
            $result = $Student->validate(true)->save($Student->getData());

            // 反馈结果
            if(false === $result)
            {   
                // 验证未通过,发生错误
                $message = '新增失败:'.$Student->getError();
            } else {
                // 提示操作成功,并跳转至学生管理页面
                return  $this->success('学生'.$Student->name.'新增成功.',url('index'));
            }

        // 获取到ThinkPHP的内置异常时，直接向上抛出，交给ThinkPHP处理
        } catch (\think\Exception\HttpResponseException $e) {
            throw $e;

        // 获取到正常的异常时，输出异常   
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return $this->error($message);
        
    }

    public function delete()
    {
        try {
            // 实例化请求类
            $Request = Request::instance();

            // 获取get数据
            $id = $Request->param('id/d');

            // 判断是否成功接收
            if (0 === $id) {
                throw new \Exception("未获取到ID信息", 1);
            }

            // 获取要删除的对象
            $Student = Student::get($id);

            // 要删除的对象不存在
            if (is_null($Student)) {
                throw new \Exception('不存在id为' . $id . '的学生，删除失败');
            }

            // 删除对象
            if (!$Student->delete()) {
                return $this->error('删除失败:' . $Student->getError());
            }

        // 获取到ThinkPHP的内置异常时,直接向上抛出,交给ThinkPHP处理
        } catch (\think\Exception\HttpResponseException $e) {
            throw $e;

        // 获取到正常的异常时,输出异常   
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        //进行跳转
        return $this->success('删除成功', url('index'));
    }

    public function edit()
    {
        try {
            $id = Request::instance()->param('id/d');

            // 判断是否成功接收
            if (is_null($id) || 0 === $id) {
                throw new \Exception('未获取到ID信息', 1);
            }

            // 在Student表模型中获取当前记录
            if (null === $Student = Student::get($id)) {
                return $this->error('未找到ID为' . $id . '的记录');
            }

            $this->assign('Student', $Student);

            return $this->fetch();
        
        // 获取到ThinkPHP的内置异常时,直接向上抛出,交给ThinkPHP处理    
        } catch (\think\Exception\HttpResponseException $e) {
            throw $e;

        // 获取到正常的异常时,输出异常       
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update()
    {
        // var_dump(Request::instance()->post());
        try {   
                $id = Request::instance()->post('id/d');

                $Student = Student::get($id);

                if (!is_null($Student)) {
                    $Student->name = Request::instance()->post('name');
                    $Student->num = Request::instance()->post('num');
                    $Student->sex = Request::instance()->post('sex/d');
                    $Student->klass_id = Request::instance()->post('klass_id');
                    $Student->email = Request::instance()->post('email');

                    // 更新
                    if (false === $Student->validate(true)->save($Student->getData())) 
                    {
                        return $this->error('更新失败'.$Student->getError());
                    }
                } else {
                    throw new \Exception("所更新的记录不存在", 1); // 调用PHP内置类时，需要在前面加上 \ 
                }

            // 获取到ThinkPHP的内置异常时,直接向上抛出,交给ThinkPHP处理
            } catch (\think\Exception\HttpResponseException $e) {
                throw $e;

            // 获取到正常的异常时,输出异常
            } catch (\Exception $e) {
                return $e->getMessage();
            }

        // 成功跳转至index控制器
        return $this->success('操作成功',url('index'));
    }







}