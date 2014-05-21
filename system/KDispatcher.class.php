<?php

/**
 * 
 * @author Kangzengji
 * @date 2012-02-22
 */
class KDispatcher {
	private static $instance = null;
	private $elisped_time = 0;
	private $session = '';
	private $url_segments = '';
	private $path_info = '';
	private $controller = '';
	private $controller_name = '';
	private $action_name = '';
	public static function getInstance() {
		if (self::$instance == null) {
			self::$instance = new self ();
		}
		return self::$instance;
	}
	
	/**
	 * all initializing works
	 */
	public function dispatch() {
		$startTime = microtime ( true );
		// whether to start session
		if (KMVC_ENABLE_SESSION) {
			KSession::start ();
		}
		// dispatch the request
		// 1. route to class->function
		$this->setupPathInfo ();
		// var_dump($this->path_info);
		$this->setupSegments ();
		// var_dump($this->url_segments);
		for($i = 0; $i < AppConfig::BASE_URL_DIR_DEPTH; $i ++) {
			array_shift ( $this->url_segments );
		}
		// var_dump($this->url_segments);
		// set up the controller class
		$this->setupController ();
		// set up the action name
		$this->setupAction ();
		if (KMVC_TIMER) {
			ob_start ();
		}
		
		$action_params = array ();
		if (isset ( $this->url_segments [3] )) {
			$action_params = $this->url_segments;
			// shit out the controller and action name
			array_shift ( $action_params );
			array_shift ( $action_params );
		}
		// call the action
		if (method_exists ( $this->controller, $this->action_name )) {
			call_user_func_array ( array (
					$this->controller,
					$this->action_name 
			), $action_params );
		} else {
			throw new KClassOrMethodNotFoundException();
		}
		if (KMVC_TIMER) {
			/* insert timing info */
			$output = ob_get_contents ();
			ob_end_clean ();
			// caculate the time elisped
			$this->elisped_time = microtime ( true ) - $startTime;
			echo str_replace ( '{KMVC_TIMER}', sprintf ( '%0.5f', $this->elisped_time ), $output );
		}
	}
	public function getControllerName() {
		return $this->controller_name;
	}
	public function getActionName() {
		return $this->action_name;
	}
	private function setupPathInfo() {
		// remove the query string after '?'
		$request_uri = $this->request_uri ();
		$this->path_info = strstr ( $request_uri, '?', true );
		if (! $this->path_info) {
			$this->path_info = $request_uri;
		}
	}
	private function setupSegments() {
		$this->url_segments = ! empty ( $this->path_info ) ? array_values ( array_filter ( explode ( '/', $this->path_info ) ) ) : null;
	}
	private function setupController() {
		$this->controller_name = ! empty ( $this->url_segments [0] ) ? preg_replace ( '!\W!', '', $this->url_segments [0] ) : KConfig::defaultController;
		if (class_exists ( $this->controller_name )) {
			$this->controller = new $this->controller_name ( $this );
		} else {
			throw new KClassOrMethodNotFoundException();
		}
	}
	private function setupAction() {
		$this->action_name = ! empty ( $this->url_segments [1] ) ? preg_replace ( '!\W!', '', $this->url_segments [1] ) : KConfig::defaultAction;
	}
	private function request_uri() {
		if (isset ( $_SERVER ['REQUEST_URI'] )) {
			$uri = $_SERVER ['REQUEST_URI'];
		} else {
			if (isset ( $_SERVER ['argv'] )) {
				$uri = $_SERVER ['PHP_SELF'] . '' . $_SERVER ['argv'] [0];
			} else {
				$uri = $_SERVER ['PHP_SELF'] . '' . $_SERVER ['QUERY_STRING'];
			}
		}
		return $uri;
	}	
}