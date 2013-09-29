<?php
class AppUtil {
    static function makeInvoiceid($email, $days, $dateline){
        return md5("$email $days $dateline");
    }
    
}