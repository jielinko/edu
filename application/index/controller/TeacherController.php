<?php
namespace app\index\controller;

use think\Controller;
use think\Request;
use think\Exception;
use app\common\model\Teacher;

class TeacherController extends IndexController
{
	/**
	 * 教师信息管理页面
	 */
	public function index()
	{
			// 获取查询信息
			$name = input('get.name');

			// 每页显示数据的条数
			$pageSize = 2;

			// 实例化Teacher
			$Teacher = new Teacher; 

			// 按条件查询数据并调用分页
	        $teachers = $Teacher->where('name','like','%'.$name.'%')->paginate($pageSize,false,[
	        	'query' => [
	        		'name' => $name, // query:url额外参数 将name值添加到后续页面url中
	        	],
	        ]);

	        // 向V层传数据
	        $this->assign('teachers', $teachers); // 调用父类(think\Conroller)中的assign()函数:模板变量赋值

	        // 取回打包后的数据
	        $htmls = $this->fetch(); // fetch():渲染模板输出

	        // 将数据返回给用户
	        return $htmls;

	}
	
	/**
	 * 增加教师信息1 - 生成添加页面
	 */
	public function add()
    {
	    // 实例化
		$Teacher = new Teacher;

		// 设置默认值
		$Teacher->id = 0;
		$Teacher->name = '';
		$Teacher->username = '';
		$Teacher->sex = 0;
		$Teacher->email = '';
		$this->assign('Teacher', $Teacher);

		// 调用edit模板
		return $this->fetch('edit');
    }

    /**
     * 对数据进行保存或更新
     * @param Teacher &$Teacher 教师 // 这使得验证和保存时的错误信息能够能过Teacher变量进行回传
     * @return bool 
     */
    
    private function saveTeacher(Teacher &$Teacher, $isUpdate = false)
    {  
		// 写入要更新的数据
		$Teacher->name = Request::instance()->post('name');
		if (!$isUpdate) {
			$Teacher->username = $Teacher->username = Request::instance()->post('username');
		}
		$Teacher->sex = Request::instance()->post('sex/d');
		$Teacher->email = Request::instance()->post('email');
    	
    	// 更新或保存
    	return $Teacher->validate(true)->save($Teacher->getData());
    }

    /**
     * 增加教师信息2 - 执行增加操作
     */
	public function insert()
    {

	    // 实例化Teacher空对象
	    $Teacher = new Teacher();
	        
	    // 新增数据
	    if (!$this->saveTeacher($Teacher)) {
	    	return $this->error('操作失败' . $Teacher->getError());
	    }

		// 提示操作成功,并跳转至教师管理页面
	    return  $this->success('教师'.$Teacher->name.'新增成功.', url('index'));
	}

    /**
     * 删除教师信息
     */
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
	        $Teacher = Teacher::get($id);

	        // 要删除的对象不存在
	        if (is_null($Teacher)) {
	            throw new \Exception('不存在id为' . $id . '的教师，删除失败');
	        }

	        // 删除对象
	        if (!$Teacher->delete()) {
	            return $this->error('删除失败:' . $Teacher->getError());
	        }

	    // 获取到ThinkPHP的内置异常时,直接向上抛出,交给ThinkPHP处理
    	} catch (\think\Exception\HttpResponseException $e) {
    		throw $e;

    	// 获取到正常的异常时,输出异常	
    	} catch (\Exception $e) {
    		return $e->getMessage();
    	}

    	// 进行跳转
	    return $this->success('删除成功', url('index'));
    }

    /**
     * 更新教师信息1 - 生成编辑页面
     */
    public function edit()
    {
    	try {
	    	// 获取传入ID
	    	$id = Request::instance()->param('id/d'); 	

	    	// 判断是否成功接收
	    	if (is_null($id) || 0 === $id) {
	    		throw new \Exception('未获取到ID信息', 1);
	    	}

			// 在Teacher表模型中获取当前记录
			if(null === $Teacher = Teacher::get($id))
			{
				// 由于在$this->error抛出了异常,所以也可以省略return(不推荐)
				return $this->error('系统未找到ID为'. $id .'的记录');
			}

			// 将Teacher数据传给V层
			$this->assign('Teacher',$Teacher);

			// 获取封装好的V层内容
			$htmls = $this->fetch();

			// 将封装好的V层内容返回给用户 
			return $htmls;

		// 获取到ThinkPHP的内置异常时,直接向上抛出,交给ThinkPHP处理	
    	} catch (\think\Exception\HttpResponseException $e) {
    		throw $e;

    	// 获取到正常的异常时,输出异常		
    	} catch (\Exception $e) {
    		return $e->getMessage();
    	}

    }

    /**
     * 更新教师信息2 - 执行更新操作
     */
    public function update()
    {

	    // 接收数据,获取要更新的关键词信息
	    $id = Request::instance()->post('id/d');

	    // 获取当前对象
	    $Teacher = Teacher::get($id);
	    	
		if (!is_null($Teacher)) {
			if (!$this->saveTeacher($Teacher, true)) {
				return $this->error('操作失败' . $Teacher->getError());
			}
		} else {
			return $this->error('当前操作的记录不存在');
		}

		// 成功跳转至index控制器
	    return $this->success('操作成功',url('index'));
    }




}