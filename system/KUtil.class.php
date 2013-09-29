<?php

/**
 * 
 * @author Kangzengji
 * @date 2012-02-22
 */
class KUtil {
    
    /**
     * json_encode with UTF-8 character unescaped.
     *
     * @param array $array            
     */
    public static function json_encode($array, $print = false) {
        $json = preg_replace ( "/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", json_encode ( $array ) );
        if ($print) {
            echo $json;
        } else {
            return $json;
        }
    }
    public static function valid_email($address) {
        if (!preg_match ( "/^([a-z0-9\\+_\\-]+)(\\.[a-z0-9\\+_\\-]+)*@([a-z0-9\\-]+\\.)+[a-z]{2,6}$/ix", $address )) {
            throw new KException('Not a Valid Email');
        }
        return $address;
    }
    static function checkNumber($n, $l, $b){
        if($n < $l || $n > $b){
            throw new KException("the Number is Less than $l or Greater than $b");
        }
        return $n;
    }
}
