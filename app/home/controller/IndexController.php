<?php

//命名空间
namespace home\controller;
//引入公共控制器
use \core\Controller;

class IndexController extends Controller{
    //默认方法
    public function index(){
        echo '欢迎来到MVC项目单一入口自定义框架！';

        //调用模型
        $m = new \home\model\TableModel();
        $res = $m->getById(1);

       	$this->assign('res',$res);
       	$this->display('index.html');
    }
}