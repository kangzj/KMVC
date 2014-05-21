<?php
class KErrorHandler {
	static function captureNormal($severity, $message, $filepath, $line) {
		// We don't bother with "strict" notices since they tend to fill up
		// the log file with excess information that isn't normally very
		// helpful.
		// For example, if you are running PHP 5 and you use version 4 style
		// class functions (without prefixes like "public", "private", etc.)
		// you'll get notices telling you that these have been deprecated.
		if ($severity == E_STRICT) {
			return;
		}
		
		// Should we display the error? We'll get the current error_reporting
		// level and add its bits with the severity bits to find out.
		$ret = true;
		if (($severity & error_reporting ()) == $severity) {
			$ret = false;
		}
		
		// Should we log the error? No? We're done...
		if (KMVC_LOG_THRESHOLD == 0) {
			return;
		}
		
		KLog::getInstance ()->log_exception ( $severity, $message, $filepath, $line );
		
		return $ret;
	}
	static function captureException($exception) {
		if (get_class ( $exception ) == 'KClassOrMethodNotFoundException') {
			KUtil::echo404AndExit ();
			return;
		}
		// Display content $exception variable
		echo '<pre>';
		print_r ( $exception );
		echo '</pre>';
	}
}