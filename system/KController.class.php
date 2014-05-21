<?php

/**
 * 
 * @author Kangzengji
 * @date 2012-02-22
 */
class KController {
    protected $request = '';
    protected $view = '';
    protected $data = '';
    protected $dispatcher = '';
    private $defaultdb = null;
    public function __construct($dispatcher) {
        $this->dispatcher = $dispatcher;
        $this->request = new KRequest ();
        $this->view = new KView ( $this );
    }
    public function __set($key, $val) {
        $this->data [$key] = $val;
    }
    public function getData() {
        return $this->data;
    }
    public function getDispatcher() {
        return $this->dispatcher;
    }
    protected function jumpTo($url, $message = '') {
    	if(strpos($url, 'http://') !== 0){
    		$url = AppConfig::BASE_URL . $url;
    	}
        echo '<html><head><title>' . $message . '</title>';
        echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
        echo '<meta http-equiv="refresh" content="0; url=' . $url . '">';
        echo '</head><body>';
        if ($message) {
            echo '<script type="text/javascript">alert("' . $message . '");location.href="' . $url . '";</script>';
        }
        echo '</body></html>';
    }
    protected function getDB() {
        if (! $this->defaultdb) {
            $this->defaultdb = new KDatabase ();
        }
        return $this->defaultdb;
    }
    public function getRequest() {
        return $this->request;
    }
}