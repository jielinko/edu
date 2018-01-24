<?php
namespace app\common\validate;

use think\Validate;

class Student extends Validate
{
	protected $rule = [
		'name' => 'require|length:2,25',
		'num' => 'require|length:1,3',
		'sex' => 'in:0,1',
		'klass_id' => 'in:1,2,3,4,5',
		'email' => 'require|email',
	];
}

