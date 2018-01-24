<?php
namespace app\common\model;

use think\Model;

/**
 * Course 课程表
 */

class Course extends Model
{
	public function klasses()
	{
		return $this->belongstoMany('Klass', 'klass_course');
	}

	/**
	 * 获取是否存在相关关联记录
 	 * @param  object 班级
	 * @return  bool
 	 */
 	
 	public function getIsChecked(Klass &$Klass)
 	{
 		// 取课程ID
 		$courseId = (int)$this->id;
 		$klassId = (int)$Klass->id;

 		// 定制查询条件
 		$map = array();
 		$map['klass_id'] = $klassId;
 		$map['course_id'] = $courseId;

 		// 从关联表中取信息: 有记录,返回true;没记录,返回false.
 		$KlassCourse = KlassCourse::get($map);
 		if (is_null($KlassCourse)) {
 			return false;
 		} else {
 			return true;
 		}

 	}

 	/**
 	 * 一对多关联
 	 */
 	
 	public function klassCourses()
 	{
 		return $this->hasMany('KlassCourse');
 	}
}



