<?php
namespace app\index\controller;

use think\Request;
use app\common\model\Course;
use app\common\model\Klass;
use app\common\model\KlassCourse;


/**
 * Course 课程管理
 */

class CourseController extends IndexController
{
	public function index()
	{
		$name = input('get.name');

		$pageSize = 2;

		$Course = new Course;

        // 按条件查询数据并调用分页
        $courses = $Course->where('name','like','%'.$name.'%')->paginate($pageSize,false,[
            'query' => [
                'name' => $name, // query:url额外参数 将name值添加到后续页面url中
            ],
        ]);	

		$this->assign('courses', $courses);
		return $this->fetch();
	}

	public function add()
	{
		$klasses = Klass::all();
		$this->assign('klasses', $klasses);
		return $this->fetch();
	}

	public function save()
	{
		// 存课程信息
		$Course = new Course();
		$Course->name = Request::instance()->post('name');

		// 新增数据并验证
		if (!$Course->validate(true)->save($Course->getData()))
		{
			return $this->error('保存错误: '. $Course->getError());
		}

		// ------ 新增班级课程信息 ------
		
		// --- 修改前 ---
		 
		// // 接收klass_id这个数据
		// $klassIds = Request::instance()->post('klass_id/a'); // /a 表示获取的类型为数组

		// // 利用klass_id这个数组,拼接为包括klass_id和course_id的二维数组
		// if (!is_null($klassIds)) {
		// 	$datas = array();
		// 	foreach ($klassIds as $klassId) {
		// 		$data = array();
		// 		$data['klass_id'] = $klassId;
		// 		$data['course_id'] = $Course->id; // 此时，由于前面已经执行过数据插入操作，所以可以直接获取到Course对象中的ID值。
		// 		array_push($datas, $data);
		// 	}

		// 	// 利用saveAll()方法, 来将二维数据存入数据库
		// 	if (!empty($datas)) {
		// 		$KlassCourse = new KlassCourse;
		// 		if (!$KlassCourse->validate(true)->saveAll($datas)) {
		// 			return $this->error('课程-班级信息保存错误: ' . $KlassCourse->getError());
		// 		}
		// 		unset($KlassCourse);  // unset出现的位置和new语句的缩进量相同，最后被执行
		// 	}
		// } 
		
		// --- 修改前 end ---
		
		// --- 修改后(基于Tp5.0.14版本) ---
		
		// 接收klass_id这个数组
		$klassIds = Request::instance()->post('klass_id/a'); // /a 表示获取的类型为数组

		// 利用klass_id这个数组,拼接为包括klass_id和course_id的二维数组
		if (!is_null($klassIds)) {
			if (!$Course->klasses()->saveAll($klassIds)) {
				return $this->error('课程-班级信息保存错误: ' . $Course->klasses()->getError());
			}
		}

		// --- 修改后 end ---
		
		// ------ 新增班级课程信息 end ------
		unset ($Course); // unset出现的位置和new语句的缩进量相同, 在返回前, 最后被执行.
		return $this->success('操作成功', url('index'));
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
            $Course = Course::get($id);

            // 要删除的对象不存在
            if (is_null($Course)) {
                throw new \Exception('不存在id为' . $id . '的课程，删除失败');
            }

            // *不仅要删除课程对象,还要删除关联表中的记录
			$map = ['course_id'=>$id];

            // 删除关联表后中的记录
            if (false === $Course->klassCourses()->where($map)->delete()) {
				return $this->error('删除班级课程关联信息发生错误' . $Course->klassCourses()->getError());
			}

			 // 删除对象
            if (!$Course->delete()) {
                return $this->error('删除失败:' . $Course->getError());
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
        $id = Request::instance()->param('id/d');
        $Course = Course::get($id);

        if (is_null($Course)) {
            return $this->error('不存在ID为' . $id . '的记录');
        }

        $klasses = Klass::all();
		$this->assign('klasses', $klasses);

        $this->assign('Course', $Course);
        return $this->fetch();
	}

	public function update()
	{
		//var_dump(Request::instance()->post());
		
		// 获取当前课程
        $id = Request::instance()->post('id/d');
        if (is_null($Course = Course::get($id))) {
            return $this->error('不存在ID为' . $id . '的记录');
        }

        // 更新课程名
        $Course->name = Request::instance()->post('name');
        if (is_null($Course->validate(true)->save($Course->getData()))) {
        	return $this->error('课程信息更改发生错误: ' . $Course->getError());
        }

		// 删除原有信息
		$map = ['course_id'=>$id];

		// 执行删除操作. 由于可能存在 成功删除0条记录,故使用false来进行判断,而不能使用
		// if (!KlassCourse::where($map)->delete()) {
		// 我们认为,删除0条记录也是删除成功
		if (false === $Course->klassCourses()->where($map)->delete()) {
			return $this->error('删除班级课程关联信息发生错误' . $Course->klassCourses()->getError());
		}

		// 增加新增数据, 执行添加操作
		$klassIds = Request::instance()->post('klass_id/a');
		if (!is_null($klassIds)) {
			if (!$Course->klasses()->saveAll($klassIds)) {
				return $this->error('课程-班级信息保存错误: ' . $Course->klasses()->getError());
			}
		}

		return $this->success('更新成功', url('index'));
	}


	
}

