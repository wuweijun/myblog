<?php

//测试模型
namespace home\model;
//引入公共模型
use \core\Model;


class TableModel extends Model{
	//增加表名
	protected $table = 'student';
}
