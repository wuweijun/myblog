<?php

//公共模型
namespace core;


class Model{
	//属性：保存Dao对象
	protected $dao;
	//保存当前表的所有字段：额外多出一个主键字段
	protected $fields;

	//实例化
	public function __construct(){
		//加载配置文件
		global $config;
		
		//实例化DAO
		$this->dao = new Dao($config['database'],$config['drivers']);

		//初始化字段信息
		$this->getFields();
	}

	//写方法
	protected function exec(string $sql){		    //这个是在子类模型中调用
	    return $this->dao->dao_exec($sql);
	}
	//获取ID
	public function getLastId(){			//这个是可能控制器调用
	    return $this->dao->dao_insert_id();
	}

	//读方法
	protected function query(string $sql,$all = false){
	    return $this->dao->dao_query($sql,$all);
	}

	//构造全表名
	protected function getTable(string $table = ''){
		//构造前缀：$config
		global $config;

		//确定表名字
		$table = empty($table) ? $this->table : $table;

		//构造全名
		return $config['database']['prefix'] . $table;
	}

	//获取全部数据：当前表
	protected function getAll(){
		//组织SQL
		$sql = "select * from {$this->getTable()}";

		//执行
		return $this->query($sql,true);		
	}

	//获取表字段
	private function getFields(){
		//通过desc来获取表字段信息
		$sql = "desc {$this->getTable()}";

		//执行
		$rows = $this->query($sql,true);

		//循环遍历
		foreach($rows as $row){
			//保存到$this->fields属性
			$this->fields[] = $row['Field'];

			//确定主键
			if($row['Key'] == 'PRI'){
				$this->fields['Key'] = $row['Field'];
			}
		}
	}

	//通过主键获取记录
	public function getById($id){
		//判定：当前表是否有主键
		if(!isset($this->fields['Key'])) return false;

		//组织SQL
		$sql = "select * from {$this->getTable()} where {$this->fields['Key']} = '{$id}'";

		//执行
		return $this->query($sql);
	}
}