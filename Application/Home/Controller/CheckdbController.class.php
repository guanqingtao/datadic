<?php
namespace Home\Controller;
use Think\Controller;
class CheckdbController extends Controller {
	protected $schema_tables_model;
	protected $schema_columns_model;
        
	function _initialize() {
		$this->schema_tables_model = M("information_schema_tables","sp_","DB_CONFIG1");
		$this->schema_columns_model = M("information_schema_columns","sp_","DB_CONFIG1");
		
    }
	
    public function index(){
		$this->display();	
    }
	
	public function check_post(){
		if(!$this->checksession()){
			$this->error('(╬▔＾▔)凸 ');
		}
		$dbuser = trim($_POST['dbuser']);
		$dbpasswd = trim($_POST['dbpasswd']);
		$dbip = trim($_POST['dbip']);
		$dbname = trim($_POST['dbname']);
		if (empty($dbuser) || empty($dbpasswd) || empty($dbip) || empty($dbname)){
			$this->error("╮(￣▽￣)╭",__APP__."/Home/checkdb");
		}
		$_SESSION['db']['dbip'] = $dbip;
		$_SESSION['db']['dbname'] = $dbname;
		$_SESSION['db']['dbpasswd'] = $dbpasswd;
		$_SESSION['db']['dbuser'] = $dbuser;
		$dbs = M("tables",'',"mysql://$dbuser:$dbpasswd@$dbip/information_schema#utf8");
		//dump("mysql://$dbuser:$dbpasswd@$dbip/information_schema#utf8");exit;
		$sql = "select `table_name` from tables where table_schema = '$dbname'";
		$res1 = $dbs->query($sql);
		$res2 = $this->schema_tables_model->field('table_name')->where(array('table_schema'=>$dbname,'display_sataus'=>1))->select();
		if(!empty($res2)){
			foreach($res1 as $key=>$value){
				$res1_[] = $value['table_name'];
			}
			foreach($res2 as $key=>$value){
				$res2_[] = $value['table_name'];
			}
			$re = array_diff($res1_,$res2_);		
		}else{
			foreach($res1 as $key=>$value){
				$res1_[] = $value['table_name'];
			}
			$re = $res1_;	
		}
		if($re){
			$this->assign('re',$re);
			$this->display();
		}else{
			$this->error("╮(￣▽￣)╭",__APP__."/Home/checkdb");
		}	
	}
	
	public function change_post(){
		$tables = $_POST['tables'];
		foreach($tables as $key=>$value){
			$tblist .= '\''.$value.'\''.',';
		}
		$tblist = rtrim($tblist,',');
		$dbip = $_SESSION['db']['dbip'];
		$dbname = $_SESSION['db']['dbname'];
		$dbpasswd = $_SESSION['db']['dbpasswd'];
		$dbuser = $_SESSION['db']['dbuser'];
		$dbs = M("tables",'',"mysql://$dbuser:$dbpasswd@$dbip/information_schema#utf8"); 
		$sql = "select t.TABLE_SCHEMA,t.TABLE_NAME,t.TABLE_COMMENT from `TABLES` t where t.TABLE_SCHEMA = '$dbname' and t.TABLE_NAME in ($tblist)";
		$res = $dbs->query($sql);
		$this->schema_tables_model->startTrans();
		$count = count($res);
		$c = 0;
		$arr = array();
		foreach($res as $key=>$value){
			if($this->schema_tables_model->add($value)){
				$arr[$c] = 1;
			}else{
				$arr[$c] = 0;
			}
			$c = $c+1;
		}
		if(array_sum($arr) == $count){
			$this->schema_tables_model->commit();
			$this->success('(O ^ ~ ^ O)', __APP__."/Home/index/db_info/table_schema/$dbname");
		}else{
			$this->schema_tables_model->rollback();
			$this->success('(≥﹏ ≤)', __APP__."/Home/index/db_info/table_schema/$dbname");
		}
		exit();
		
	}
	
	//函数
	protected function checksession() { 
        if ($_SESSION['name'] == 'success'){
			return true;
		}else{
			return false;
		}
	} 
	
	
}