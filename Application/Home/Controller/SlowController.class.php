<?php
namespace Home\Controller;
use Think\Controller;
class SlowController extends Controller {
	protected $schema_tables_model;
	protected $schema_columns_model;
        
	function _initialize() {
		$this->global_query_review_model = M("global_query_review","sp_","DB_CONFIG1");
		$this->global_query_review_history_model = M("global_query_review_history","sp_","DB_CONFIG1");
		
    }
	
    public function index(){
		$now = date("Y-m-d",strtotime('-1 day'));		
		$global_query_review_history = $this->global_query_review_history_model->field('checksum,db_max,sample,ts_min,ts_max')->group('checksum')->where("ts_max > '%s' and checksum not in ( %s,%s )",$now,'5255103209479346193','9308995099268723497')->select();
		//dump($this->global_query_review_history_model->getLastSql());
		$this->assign('global_query_review_history',$global_query_review_history);
		$this->display();	
    }
	
	public function get_explain(){
		$checksum = $_GET['checksum'];
		$global_query_review_history = $this->global_query_review_history_model->field('db_max,sample')->where("checksum = '%s'",$checksum)->find();
		$dbip = '192.168.5.247';
		$dbname = $global_query_review_history['db_max'];
		$dbuser = 'datadic';
		$dbpasswd = '123456';
		#dump("mysql://$dbuser:$dbpasswd@$dbip/$dbname#utf8");
		$dbs = M('','',"mysql://$dbuser:$dbpasswd@$dbip/$dbname#utf8");
		$s = $global_query_review_history['sample'];
		$sql = "explain ".$global_query_review_history['sample'];
		$res = $dbs->query($sql);
		$this->assign('s',$s);
		$this->assign('res',$res);
		$this->display();
	}
	
	public function mongo_slow(){
		$iflashbuy_log = D("Slow");
		$result = $iflashbuy_log->field("op,ns,query,command,updateobj,lockStats,client,ts,client,millis")->order('ts desc')->limit(20)->select();
		#dump($result);
		$this->assign('result',$result);
		$this->display();		
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