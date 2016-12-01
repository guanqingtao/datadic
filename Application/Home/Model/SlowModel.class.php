<?php
namespace Home\Model;
use Think\Model\MongoModel;
Class SlowModel extends MongoModel { 
	protected $connection = 'DB_MONGO1';
	protected $dbName='iflashbuy-log';
	protected $trueTableName = 'system.profile';
}