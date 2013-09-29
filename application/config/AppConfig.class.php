<?php
class AppConfig {
    const BASE_URL = 'http://rs.kangzj.net/';
    public static $dbconfig = array (
            'default' => array (
                    'type' => 'mysql',
                    'host' => 'localhost',
                    'port' => '3306',
                    'user' => 'root',
                    'pass' => '',
                    'name' => 'rapidstation',
                    'charset' => 'utf8',
                    'persistent' => false 
            ) 
    );
    public static $paypalconfig = array (
            'business' => 'billing@xtom.com',
    );
}