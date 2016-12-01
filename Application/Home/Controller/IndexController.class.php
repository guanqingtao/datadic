<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
	protected $schema_tables_model;
	protected $schema_columns_model;
        
	function _initialize() {
		$this->schema_tables_model = M("information_schema_tables","sp_","DB_CONFIG1");
		$this->schema_columns_model = M("information_schema_columns","sp_","DB_CONFIG1");
		
    }
	
    public function index(){
		$this->display();	
    }
	
	public function db_info(){
		$table_schema = trim($_GET['table_schema']);
		$list_L = $this->schema_tables_model->where(array('table_schema'=>$table_schema,'display_sataus'=>1))->select();
		//dump($list_L);
		$list_L_arr = array();
		foreach($list_L as $key => $val){
			$kv = $list_L[$key]['table_name'];
			$list_L_arr[$kv] = $val;
		}
		$this->assign('headname',$table_schema);
		$this->assign('table_schema',$table_schema);
		$this->assign('schema_list',$list_L_arr);
		$this->display();
       		
    }
	
	public function table_info(){
		$columns_id = intval($_GET['table_id']);
		$table_info = $this->schema_tables_model->where(array("id"=>$columns_id))->find();
		$Prev_id = $this->schema_tables_model->field('id, table_name')->where("`id` < $columns_id")->order('`id` DESC')->limit(0,1)->find();
		$Next_id = $this->schema_tables_model->field('id, table_name')->where("`id` > $columns_id")->order('`id` ASC')->limit(0,10)->find();
		$table_schema = $table_info['table_schema'];
		$table_name = $table_info['table_name'];

		$table_info['extra_des'] = htmlspecialchars_decode($table_info['extra_des']);
		$list_L = $this->schema_columns_model->where(array('table_schema'=>$table_schema,'table_name'=>$table_name))->select();
		$list_L_arr = array();
		foreach($list_L as $key => $val){
			$kv = $list_L[$key]['column_name'];
			$list_L_arr[$kv] = $val;
		}
		//dump($list_L_arr);
		$this->assign('headname',$table_schema);
		$this->assign('table_info',$table_info);
		$this->assign('Prev',$Prev_id);
		$this->assign('Next',$Next_id);
		$this->assign('columns_info',$list_L_arr);
		$this->display();
	}
	
	public function table_sync(){
		if(empty($_SESSION['db'])){
			$this->error("---\\(˙<>˙)/---",__APP__."/Home/checkdb");
		}
		$table_id = intval($_GET['table_id']);
		$table_info = $this->schema_tables_model->where(array("id"=>$table_id))->find();
		$table_schema = $table_info['table_schema'];
		$table_name = $table_info['table_name'];
		$dbip = $_SESSION['db']['dbip'];
		$dbname = $_SESSION['db']['dbname'];
		$dbpasswd = $_SESSION['db']['dbpasswd'];
		$dbuser = $_SESSION['db']['dbuser'];
		$dbs = M("columns",'',"mysql://$dbuser:$dbpasswd@$dbip/information_schema#utf8"); 
		//dump("mysql://$dbuser:$dbpasswd@$dbip/information_schema#utf8");
		$sql = "select t.TABLE_SCHEMA ,t.TABLE_NAME,t.COLUMN_NAME,t.COLUMN_DEFAULT,t.IS_NULLABLE,t.COLUMN_TYPE,t.COLUMN_KEY,t.EXTRA,t.COLUMN_COMMENT from `COLUMNS` t where t.TABLE_SCHEMA = '$dbname' and t.TABLE_NAME = '$table_name'";
		$res = $dbs->query($sql);
		if(empty($res)){
			$this->error('(╬▔皿▔)凸', __APP__."/Home/index/table_info/table_id/$table_id");
			exit();
		}
		$this->schema_columns_model->startTrans();
		$count = count($res);
		$c = 0;
		$arr = array();
		foreach($res as $key=>$value){
			if($this->schema_columns_model->add($value,array(),true)){
				$arr[$c] = 1;
			}else{
				$arr[$c] = 0;
			}
			$c = $c+1;
		}
		if(array_sum($arr) == $count){
			$this->schema_columns_model->commit();
			$this->success('(O ^ ~ ^ O)', __APP__."/Home/index/table_info/table_id/$table_id");
		}else{
			$this->schema_columns_model->rollback();
			$this->error('(≥﹏ ≤)', __APP__."/Home/index/table_info/table_id/$table_id");
		}
		exit();		
	}
	
	public function table_edit(){
		$table_id = intval($_GET['table_id']);
		$table_info = $this->schema_tables_model->where(array("id"=>$table_id))->find();
		$table_schema = $table_info['table_schema'];
		$table_name = $table_info['table_name'];
		$columns_info = $this->schema_columns_model->where(array('table_schema'=>$table_schema,'table_name'=>$table_name))->select();
		//dump($table_info);exit;
		$this->assign('columns_id',$columns_id);
		$this->assign('table_info',$table_info);
		$this->assign('columns_info',$columns_info);
		$this->display();
	}
	
	public function validation_info(){
		
		$this->display();
	}
	
	# 动作
	public function table_edit1Post(){
		$table=I("post.post");
		$table_id = $table['id'];
		//dump($table);
		$res = $this->schema_tables_model->where(array('id'=>$table_id))->save($table);
		if($res){
			$this->success('ヽ(ˋ▽ˊ)ノ',__APP__."/Home/index/table_info/table_id/$table_id");
		}else{
			echo $this->schema_tables_model->getLastSql();
			$this->error('ヽ(ˋДˊ)ノ');			
		}
		exit();
	}
	
	public function table_edit2Post(){
		$table=I("post.post");
		$id = $_POST['id'];
		$structure = $this->table_info_model->field('structure')->where(array("id"=>$id))->find();
		$structure = $structure['structure'];
		$arr = array();
		//dump($structure);
		if($structure == '0'){
			$key = $table['name'];
			$arr = array($key=>$table);
			$t = json_encode($arr);
		}else{
			$arr = json_decode($structure,true);
			$key = $table['name'];
			$arr[$key] = $table;
			$t = json_encode($arr);
		}
		$res = $this->table_info_model->where(array("id"=>$id))->setField('structure',$t);
		if($res){
			$this->success('乀(ˉεˉ乀)', __APP__."/Home/index/table_edit/table_id/$id");
		}else{
			echo $this->table_info_model->getLastSql();
		}
		exit();
	}
	
	public function table_edit3Post(){
		$id = intval($_POST['id']);
		$extra_des = htmlspecialchars($_POST['extra_des']);
		$res = $this->schema_tables_model->where(array("id"=>$id))->setField('extra_des',$extra_des);
		if($res){
			$this->success('(•‾̑⌣‾̑•)✧˖°', __APP__."/Home/index/table_info/table_id/$id");
		}else{
			echo $this->schema_tables_model->getLastSql();
		}
		exit();
	}
	
	public function validation_post(){
		$amount = intval($_POST['amount']);
		if (!$amount){
			session('name',null);
			$this->error('┑(￣Д ￣)┍ ');
		}else if($amount == 123456){
			session('name','success');
			$this->success('(๑¯ิε ¯ิ๑)', __APP__."/Home/checkdb/index");
		}else{
			session('name',null);
			$this->error('ㄟ(▔,▔)ㄏ');
		}
		
	}
	
	
	#ajauxt
	public function aj_columns_post(){
		$column_id = intval($_POST['column_id']);
		$column_comment = trim($_POST['column_comment']);
		$res = $this->schema_columns_model->where(array("id"=>$column_id))->setField('column_comment',$column_comment);
		if($res){
			echo json_encode(array('success' => 1, 'message' => '发布成功！'));
		}else{
			//echo ($this->schema_columns_model->getLastSql());
			echo json_encode(array('success' => 0, 'message' => '发布失败！'));
		}
		exit();
		//$this->table_info_model
	}
	
	public function aj1_tables_post(){
		$table_id = intval($_POST['table_id']);
		$table_comment = trim($_POST['table_comment']);
		$modify_time = date('Y-m-d H:i',time());
		$res = $this->schema_tables_model->where(array("id"=>$table_id))->setField(array('table_comment'=>$table_comment,'modify_time'=>$modify_time));
		if($res){
			echo json_encode(array('success' => 1, 'message' => '更新成功！'));
		}else{
			echo json_encode(array('success' => 0, 'message' => '发布失败！'));
		}
		exit();
	}
	
	public function aj2_tables_post(){
		$table_id = intval($_POST['table_id']);
		$developer = trim($_POST['developer']);
		$modify_time = date('Y-m-d H:i',time());
		$res = $this->schema_tables_model->where(array("id"=>$table_id))->setField(array('developer'=>$developer,'modify_time'=>$modify_time));
		if($res){
			echo json_encode(array('success' => 1, 'message' => '更新成功！'));
		}else{
			echo json_encode(array('success' => 0, 'message' => '发布失败！'));
		}
		exit();
	}
	
	public function aj_check_table_post(){
		$id = $_POST['id'];
		exit();
		
	}

	//函数
	protected function array_diff_assoc2_deep($array1, $array2) { 
        $ret = array(); 
		foreach ($array1 as $k => $v) {     
			if (!isset($array2[$k])) {
				$ret[$k] = $v; 
				//dump($v);
			}else if (is_array($v) && is_array($array2[$k])){
				$ret[$k] = $this->array_diff_assoc2_deep($v, $array2[$k]); 
			}else if ($v != $array2[$k]){ 
				$ret[$k] = $v; 
			}else {
				unset($array1[$k]);
			}			
		} 
		return $ret; 
} 
	
}