<?php
namespace app\common\model;

use think\Model;

/**
 * Teacher 教师表
 */

class Teacher extends Model
{
	/**
	 * 用户登录
	 * @param  string $username 用户名
	 * @param  string $password 密码
	 * @return  boolean 成功返回true, 失败返回false
	 */ 
	
	static public function login($username, $password)
	{
		// 验证用户是否存在
		$map = array('username'=>$username);
		$Teacher = self::get($map);

		if (!is_null($Teacher)) {
			// 验证密码是否正确
			if ($Teacher->checkPassword($password)) {
				// 登录
				session('teacherId',$Teacher->getData('id'));
				return true;
			}
		}
		return false; 
	}

	/**
	 * 验证密码是否正确
	 * @param  string $password 密码  
	 * @return  boolean
	 */
	
	public function checkPassword($password)
	{
		if ($this->getData('password') === $this::encryptPassword($password))
		{
			return true;
		} else {
			return false;
		}
		
	}

	/**
	 * 密码加密算法
	 * @param  string $password 加密前密码
	 * @return  string 加密后密码
	 */
	
	static public function encryptPassword($password)
	{
		if (!is_string($password)) {
			throw new \RuntimeException("传入变量类型非字符串, 错误码2", 2);
			// 细化异常类型、抛出异常状态码
		}
		// 实际的过程中,我们还借助其他字符串算法,来实现不同的加密
		return sha1(md5($password).'salt');
	}

	/**
	 * 注销
	 * @return  boolean 成功true, 失败false
	 */

	static public function logout()
	{
		// 销毁session中的数据
		session('teacherId', null);
		return true;
	}

	/**
	 * 判断用户是否已登录
	 * @return  boolean 已登录true
	 */
	
	static public function isLogin()
	{
		$teacherId = session('teacherId');

		// isset() 检测变量是否设置 
		if (isset($teacherId)){  
			return true;
		} else {
			return false;
		}
	}

}