<?php
namespace app\common\validate;
use think\Validate;

class KlassCourse extends Validate
{
	protected $rule = [
        'klass_id'  => 'require',
        'course_id' => 'require'
    ];
}