<?php

/**
 * KLog class
 * 
 * @author Kangzengji
 * @date 2012-02-22
 */
class KLog {
    private static $instance;
    const date_pattern = 'Y-m-d';
    private $log_file_name = '';
    private $log_level = array (
            'debug' => 1,
            'info' => 2,
            'error' => 3 
    );
    var $levels = array (
            E_ERROR => 'Error',
            E_WARNING => 'Warning',
            E_PARSE => 'Parsing Error',
            E_NOTICE => 'Notice',
            E_CORE_ERROR => 'Core Error',
            E_CORE_WARNING => 'Core Warning',
            E_COMPILE_ERROR => 'Compile Error',
            E_COMPILE_WARNING => 'Compile Warning',
            E_USER_ERROR => 'User Error',
            E_USER_WARNING => 'User Warning',
            E_USER_NOTICE => 'User Notice',
            E_STRICT => 'Runtime Notice' 
    );
    public static function getInstance() {
        if (! self::$instance) {
            self::$instance = new self ();
        }
        return self::$instance;
    }
    private function __construct() {
        $this->setupLogFileName ();
    }
    private function setupLogFileName() {
        $this->log_file_name = KMVC_APPDIR . 'log' . DS . 'log-' . date ( self::date_pattern ) . '.log';
    }
    public function i($message) {
        $this->log ( 'info', $message );
    }
    public function d($message) {
        $this->log ( 'debug', $message );
    }
    public function e($message) {
        $this->log ( 'error', $message );
    }
    public function log($level, $message) {
        if ($this->log_level [$level] >= KMVC_LOG_THRESHOLD) {
            $str = date ( 'Y-m-d H:i:s' ) . ' [' . $level . '] ' . $message . "\n";
            $this->append2File ( $str );
        }
    }
    public function log_exception($severity, $message, $filepath, $line) {
        $severity = (! isset ( $this->levels [$severity] )) ? $severity : $this->levels [$severity];
        $this->e ( 'Severity: ' . $severity . '  --> ' . $message . ' ' . $filepath . ' ' . $line );
    }
    /**
     * append to file.
     * if the file doesnot exist, create it.
     *
     * @param string $str            
     * @param string $filename            
     */
    public function append2File($str) {
        if (! $handle = fopen ( $this->log_file_name, 'a' )) {
            throw new KException ( 'File Open Exception: ' . $this->log_file_name );
        }
        if (fwrite ( $handle, $str ) === false) {
            throw new KException ( 'File Write Exception: ' . $this->log_file_name );
        }
    }
}

