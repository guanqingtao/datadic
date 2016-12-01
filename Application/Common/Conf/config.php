<?php
return array(
	'DB_CONFIG1' => array(
			//'配置项'=>'配置值'
			'DB_TYPE' => 'mysql',
			'DB_HOST' => '192.168.5.247',
			'DB_NAME' => 'datadic',
			'DB_USER' => 'root',
			'DB_PWD' => '010304922',
			'DB_PORT' => '3306',
			'DB_PREFIX' => 'sp_',
		),
	'DB_CONFIG2' => array(
			//'配置项'=>'配置值'
			'DB_TYPE' => 'mysql',
			'DB_HOST' => '127.0.0.1',
			'DB_NAME' => 'product_test',
			'DB_USER' => 'root',
			'DB_PWD' => '123456',
			'DB_PORT' => '3306',
			'DB_PREFIX' => '',
		),
	'DB_MONGO1' => array(
		//'配置项'=>'配置值'
			'DB_TYPE' => 'mongo',
			'DB_HOST' => '192.168.5.246',
			'DB_NAME' => 'iflashbuy-log',
			'DB_USER' => '',
			'DB_PWD' => '',
			'DB_PORT' => '27017',
	),
	'evn' => array(
			'db1_name' => 'iflashbuy',
			'db1_value' => 'iflashbuy(mysql测试机244)',
			'db2_name' => 'zcode_uat',
			'db2_value' => 'zcode_uat(mysql测试机62)',
	    )
	
);