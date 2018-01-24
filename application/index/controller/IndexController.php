<?php
namespace app\index\controller;

use think\Controller;
use app\common\model\Teacher;

/**
 * IndexController既是类名，也是文件名，说明这个文件的名字为Index.php。
 * 由于其子类需要使用think\Controller中的函数，所以在此必须进行继承，并在构造函数中，进行父类构造函数的初始化
 */

class IndexController extends Controller
{
    public function __construct()
	{
		// 调用父类构造函数(必须)
		parent::__construct();

		// 验证用户是否登录
		if (!Teacher::isLogin()) {
			return $this->error('please login first', url('Login/index'));
		}
	}

	// public function index()
	// {	
	// }
}


	
