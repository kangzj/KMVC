<?php
class AppConfig {
	const BASE_URL = 'http://stwiki.amap.com/dv/';
	const BASE_URL_DIR_DEPTH = 1;
	const LOGIN_FLAG = 'login';
	const LOGIN_NAME = 'loginname';
	const LOGIN_ACCESS = 'access';
	public static $dbconfig = array (
			'default' => array (
					'type' => 'mysql',
					'host' => 'localhost',
					'port' => '3306',
					'user' => 'root',
					'pass' => '',
					'name' => 'dv',
					'charset' => 'utf8',
					'persistent' => false 
			) 
	);
	public static $stat_group = array (
			'entrance' => '入口分布',
			'sp' => '检索量分布',
			'idq' => '详情页点击量分布',
			'checkout' => '结单量分布',
			'transrate' => '8行业详情页转化率'
	);
}