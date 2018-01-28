<?php
namespace app\index\controller;

use think\Controller;
use think\Exception;


class TestController extends Controller
{
     // 对数据进行保存或更新
     private function saveKlass(Klass &$Klass)
     {
         // 数据更新
         $Klass->name = Request::instance()->post('name');
         $Klass->teacher_id = Request::instance()->post('teacher_id/d');

         //更新或保存
         return $Klass->validate(true)->save($Klass->getData());
     }

	// 执行结果: 系统发生错误 依次由两个 catch 获取.
	public function test1()
    {
    	try {
            return $this->error("系统发生错误");// thinkphp的异常
    		throw new \Exception("Error Processing Request", 1); // 自定义抛出异常

    	// 获取到ThinkPHP的内置异常时,直接向上抛出,交给ThinkPHP处理	
    	} catch (\think\Exception\HttpResponseException $e) {
    		throw $e;

    	// 获取到正常的异常时,输出异常
    	} catch (\Exception $e) {
    		return $e->getMessage();
    	}

    }


	// 执行结果: Error Processing Request 直接由第二个 catch 获取.    
	public function test2()
    {
    	try {
    		throw new \Exception("Error Processing Request", 1); // 自定义抛出异常
    		return $this->error("系统发生错误");// thinkphp的异常

    	// 获取到ThinkPHP的内置异常时,直接向上抛出,交给ThinkPHP处理	
    	} catch (\think\Exception\HttpResponseException $e) {
    		throw $e;

    	// 获取到正常的异常时,输出异常
    	} catch (\Exception $e) {
    		return $e->getMessage();
    	}

    }


}
