<?php

/**
 * put all request params in this class
 * 
 * @author Kangzengji
 * @date 2012-02-22
 */
class KRequest {
	private $get_params = array ();
	private $post_params = array ();
	public function __construct() {
		foreach ( $_GET as $key => $val ) {
			$this->get_params [$key] = $val;
		}
		
		foreach ( $_POST as $key => $val ) {
			$this->post_params [$key] = $val;
		}
		if (KMVC_LOG_THRESHOLD != 0) {
			unset ( $_GET );
			unset ( $_POST );
		}
	}
	
	/**
	 * get the raw input data
	 */
	public function getRawPostInput() {
	}
	public function getGetParam($key, $default = '') {
		return array_key_exists ( $key, $this->get_params ) ? $this->get_params [$key] : $default;
	}
	public function getPostParam($key, $default = '') {
		return array_key_exists ( $key, $this->post_params ) ? $this->post_params [$key] : $default;
	}
}

