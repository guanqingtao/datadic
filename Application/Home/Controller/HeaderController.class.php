<?php
namespace Home\Controller;
use Think\Controller;
class HeaderController extends Controller {
	
	function _initialize(){
		$db_name = C('SIT_DB');
	}
	
    public function header(){
		dump($db_name);
		$this->display();	
    }

}