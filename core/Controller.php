<?php 

//命名空间
namespace core;


class Controller{
	//增加属性：保存对象：为了让子类能够调用和访问（自己跨方法）
	protected $smarty;

	//构造方法：实现一些需要初始化才能使用的内容
	public function __construct(){
		//实现smarty的初始化
		//1.加载Smarty
		include VENDOR_PATH . 'smarty/Smarty.class.php';

		//2.实例化
		$this->smarty = new \Smarty();

		//3.设置Smarty
		$this->smarty->template_dir = APP_PATH . P . '/view/' . C . '/';
	    $this->smarty->caching = false;				//开发阶段不缓存
	    $this->smarty->cache_dir = APP_PATH . P . '/cache';
	    $this->smarty->cache_lifetime = 120;
	   	$this->smarty->compile_dir = APP_PATH . P . '/template_c';
	}

	//smarty的二次封装
	protected function assign($key,$value){
	    //调用smarty实现
	    $this->smarty->assign($key,$value);
	}

	protected function display($file){
	    $this->smarty->display($file);
	}

	//错误跳转
	protected function error($msg,$a = A,$c = C,$p = P,$time = 3){
	    $refresh = 'Refresh:' . $time . ';url=' . URL . 'index.php?c=' . $c . '&a=' . $a . '&p=' . $p;
	    header($refresh);
	    echo $msg;
	    exit;   
	}

	//成功跳转
	protected function success($msg,$a = A,$c = C,$p = P,$time = 3){
	    $refresh = 'Refresh:' . $time . ';url=' . URL . 'index.php?c=' . $c . '&a=' . $a . '&p=' . $p;
	    header($refresh);
	    echo $msg;
	    exit;   
	}
}