<?php
namespace app\index\controller;

use think\Controller;
use think\Request;
use app\common\model\Klass;
use app\common\model\Teacher;

class KlassController extends IndexController
{
	// 班级信息管理主页
	public function index()
	{
		// 获取查询信息
		$name = input('get.name');

		// 每页显示数据的条数
		$pageSize = 2;

		// 实例化Klass
		$Klass = new Klass;

		// 按条件查询数据并调用分页
		$klasses = $Klass->where('name','like','%'.$name.'%')->paginate($pageSize,false,[
			'query' => [
				'name' => $name, // query:url额外参数 将name值添加到后续页面url中
			],
		]);

		// 向V层传数据
		$this->assign('klasses', $klasses);

		// 渲染数据
		return $this->fetch();              
	}

	// 对数据进行保存或更新
	 private function saveKlass(Klass &$Klass, $isUpdate = false)
	 {
	 	 // 数据更新
	   	 if (!$isUpdate) {
	   	 	 $Klass->name = Request::instance()->post('name');
	   	 }
	     $Klass->teacher_id = Request::instance()->post('teacher_id/d');

	     //更新或保存
	     return $Klass->validate(true)->save($Klass->getData());
	 }

	// 新增班级信息页面
	public function add()
	{
		try {
			// 实例化$Klass
			$Klass = new Klass;

			// 设置默认值
			$Klass->name = '';
			$Klass->id = 0;
			$Klass->teacher_id = 0;

			$this->assign('Klass', $Klass);

			// 获取所有的教师信息
			$teachers = Teacher::all();
			$this->assign('teachers', $teachers);
			return $this->fetch('edit');

		} catch (\Exception $e) {
			return '系统错误'.$e->getMessage();
		}
	}

	// 保存新增班级信息
	public function insert()
	{
		$message = ''; // 提示信息

		try {
			// 实例化班级并赋值
			$Klass = new Klass();

			// 新增数据
			if (!$this->saveKlass($Klass)) {
				// 验证未通过,发生错误
				$message = '数据添加错误: '.$Klass->getError();
			} else {	
			// 提示操作成功,并跳转至班级管理页面
			return $this->success('班级'.$Klass->name.'新增成功', url('index'));
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

	// 删除班级信息
	public function delete()
	{ 
		try {	
			// 实例化请求类
	    	$Request = Request::instance();

	    	// 获取get数据
	    	$id = $Request->param('id/d'); // “/d”表示将数值转化为“整型”

	    	// 判断是否成功接收
		    if (0 === $id) {
		    	throw new \Exception("未获取到ID信息", 1);
		    }

	        // 获取要删除的对象
	        $Klass = Klass::get($id);

	        // 要删除的对象不存在
	        if (is_null($Klass)) {
	            throw new \Exception('不存在id为' . $id . '的班级，删除失败');
	        }

	        // 删除对象
	        if (!$Klass->delete()) {
	            return $this->error('删除失败:' . $Klass->getError());
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

	// 编辑班级信息页面1 - 生成编辑页面
	public function edit()
	{
		try {
			// 获取传入ID
			$id = Request::instance()->param('id/d');

			// 判断是否成功接收
	    	if (is_null($id) || 0 === $id) {
	    		throw new \Exception('未获取到ID信息', 1);
	    	}

			// 获取用户操作的班级信息
			if (null === $Klass = Klass::get($id)) 
			{
				return $this->error('系统未找到ID为' . $id . '的记录');
			}

			// 将Klass数据传给V层
			$this->assign('Klass', $Klass);

			// 获取所有的教师信息
			$teachers = Teacher::all();

			// 将所有的教师信息传给V层
			$this->assign('teachers', $teachers);

			// 渲染编辑页面
			return $this->fetch('edit');

		// 获取到ThinkPHP的内置异常时,直接向上抛出,交给ThinkPHP处理
		} catch (\think\Exception\HttpResponseException $e) {
			throw $e;

		// 获取到正常的异常时,输出异常	
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	// 编辑班级信息页面2 - 执行更新操作
	public function update()
    {
        try {
        	// 接收数据,获取要更新的关键词信息
        	$id = Request::instance()->post('id/d');

	        // 获取传入的班级信息
	        $Klass = Klass::get($id);

	        if (!is_null($Klass)) {
	        	if (!$this->saveKlass($Klass, true)) {
	        		return $this->error('更新失败' . $Klass->getError());
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