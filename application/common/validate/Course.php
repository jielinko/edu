<?php
namespace app\common\validate;

use think\Validate;

class Course extends Validate
{
	protected $rule = [
		'name' => 'require|length:2,25',
	];
}