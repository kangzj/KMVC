<?php

/**
 * 
 */
error_reporting ( E_ALL );

// define kmvc version
define ( 'KMVC_VERSION', '0.1' );

// directory separator alias
define ( 'DS', DIRECTORY_SEPARATOR );

// set the base directory
define ( 'KMVC_BASEDIR', dirname ( __FILE__ ) . DS . '..' . DS . '..' . DS );

define ( 'KMVC_APPDIR', KMVC_BASEDIR . 'application' . DS );

define ( 'KMVC_SYSDIR', KMVC_BASEDIR . 'system' . DS );

define ( 'KMVC_CACHEDIR', KMVC_BASEDIR . 'application' . DS . 'cache' . DS );

define ( 'KMVC_LOG_THRESHOLD', 3 );

define ( 'KMVC_TIMER', true );

define ( 'KMVC_ENABLE_SESSION', true );

// load autoload library
require KMVC_SYSDIR . 'KAutoload.class.php';
require KMVC_SYSDIR . 'KException.class.php';
// KAutoload
KAutoload::init ( KMVC_BASEDIR, '.class.php' );
//global error handling
set_error_handler ( array ( 'KErrorHandler', 'captureNormal' ));
//global exception handling
set_exception_handler ( array ( 'KErrorHandler', 'captureException' ));
// starting kmvc
KDispatcher::getInstance ()->dispatch ();