<?php
namespace Home\Controller;
use Think\Controller;
class OrdertestController extends Controller {
	protected $product_model;
	
	function _initialize() {
		$this->product_model = M("product_base","","DB_CONFIG2");
    }
	
	public function index(){
		$product = $this->product_model->select();
		$this->assign('product',$product);
		$this->display();	
    }
	
	public function orderPost(){
		var_dump($_POST['checkbox']);
		exit;
	}
}