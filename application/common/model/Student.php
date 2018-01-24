<?php
namespace app\common\model;

use think\Model;

/**
 * Student 学生表
 */

class Student extends Model
{

	protected $dateFormat = 'Y年m月d日'; // 日期格式

	/**
	 * 自定义自转换字符
	 * @var  array
	 */
	
	protected $type = [
		'create_time' => 'datetime',
	];


	/**
	 * 输出性别的属性
	 * @return  string 0男, 1女
	 */
	
	public function getSexAttr($value)
	{
		$status = array('0'=>'男','1'=>'女');
		$sex = $status[$value];
		if (isset($sex))
		{
			return $sex;
		} else {
			return $status[0]; // $value>=2时返回默认值男
		}
	}

	/**
	 * 获取要显示的创建时间
	 * @param  int $value 时间戳 
	 * @return  string 转换后的字符串
	 */
	
	public function getCreateTimeAttr($value)
	{
		return date('Y-m-d', $value);
	}

	/**
	 * ThinkPHP使用一个叫做__get()的魔法函数来完成这个函数的自动调用
	 * @return  返回了一个Klass对象
	 */
	
	public function klass()
	{
		return $this->belongsTo('Klass');
	}
}