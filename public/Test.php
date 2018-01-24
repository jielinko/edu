
<?php
class Test
{
    private $data = array(
        'name' => '张三',
        'sex'   => '0'
        );

    public function __get($name)
    {
        // 校验在$this->data中是否存在这个健值。
        // 如果存在，即返回，如果不存在，则返回$this->data整个数组。
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        } else {
            return '字段' . $name . '不存在';
        }
    }

    public function __set($name, $value)
    {	
    	echo '$name is ' . $name . ', $value is ' . $value . '<br />';
        $this->data[$name] = $value;
    }
}

$Test = new Test();
$Test->name = '李四';
$Test->sex = '1';
echo $Test->name . '<br />';
echo $Test->sex;

//并不存在hello字段
echo $Test->hello;