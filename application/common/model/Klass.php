<?php
namespace app\common\model;

use think\Model;

/**
 * Klass 班级表
 */

class Klass extends Model
{
	private $Teacher;

	/**
	 * 获取对应的教师 (辅导员) 信息
	 * @return  Teacher 教师
	 */
	
	public function teacher()
	{
		return $this->belongsTo('Teacher');
	}

	public function courses()
	{
		return $this->belongsToMany('Course', 'klass_course');
	}

}