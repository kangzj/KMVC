<?php

class KSession {

    private static $session_id = '';

    public static function start() {
        session_start();
        self::$session_id = session_id();
    }

    public static function getSessionId() {
        return self::session_id;
    }

    public static function set($name, $value) {
        $_SESSION [$name] = $value;
    }

    public static function get($name) {
        if (isset($_SESSION [$name]))
            return $_SESSION [$name];
        else
            return false;
    }

    public static function del($name) {
        unset($_SESSION [$name]);
    }

    public static function destroy() {
        $_SESSION = array();
        session_destroy();
    }

}

