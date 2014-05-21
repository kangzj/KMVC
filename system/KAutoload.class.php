<?php

/**
 * 
 * @name KAutoload
 * @author Kangzj
 * @date 2012.02.21
 *
 */
class KAutoload {
	private static $instance = '';
	private static $classFileMapping = array ();
	private static $dir = '';
	private static $ext = '';
	private static $autoloadCacheFile = '';
	const cacheTime = 3600;
	
	/**
	 * find all php class files and register autoload function.
	 *
	 * @param unknown_type $dir        	
	 * @param unknown_type $ext        	
	 */
	public static function init($dir, $ext) {
		self::$dir = $dir;
		self::$ext = $ext;
		$classFileMapping = &self::$classFileMapping;
		self::$autoloadCacheFile = KMVC_CACHEDIR . 'autoload.cache.php';
		if (file_exists ( self::$autoloadCacheFile ) && time () - filectime ( self::$autoloadCacheFile ) < self::cacheTime) {
			require_once self::$autoloadCacheFile;
		} else {
			$allFiles = self::glob_recursive ( $dir, '*' . $ext );
			foreach ( $allFiles as $file ) {
				$className = basename ( $file, $ext );
				$className = strtolower ( $className );
				$classFileMapping [$className] = $file;
			}
			$data = '<?php $classFileMapping=' . var_export ( $classFileMapping, true ) . ';';
			file_put_contents ( self::$autoloadCacheFile, $data, LOCK_EX );
		}
		// self::$classFileMapping = $classFileMapping;
		// register the autoload function
		spl_autoload_register ( array (
				'KAutoload',
				"loadClass" 
		) );
	}
	
	/**
	 * glob to find all files end with $ext
	 *
	 * @param string $dir        	
	 * @param string $ext        	
	 */
	public static function glob_recursive($dir, $ext) {
		$files = glob ( $dir . $ext );
		$files = empty ( $files ) ? array () : $files;
		$child_dirs = glob ( $dir . '*', GLOB_ONLYDIR | GLOB_NOSORT | GLOB_MARK );
		if (! empty ( $child_dirs )) {
			foreach ( $child_dirs as $subdir ) {
				$child_files = self::glob_recursive ( $subdir, $ext );
				$files = array_merge ( $files, empty ( $child_files ) ? array () : $child_files );
			}
		}
		return $files;
	}
	
	/**
	 * register function to autoload classes
	 *
	 * @param string $className        	
	 * @throws KException
	 */
	public static function loadClass($className) {
		$className = strtolower ( $className );
		if (isset ( self::$classFileMapping [$className] ) && file_exists ( self::$classFileMapping [$className] )) {
			require_once self::$classFileMapping [$className];
		} else {
			if (file_exists ( self::$autoloadCacheFile )) {
				unlink ( self::$autoloadCacheFile );
			}
			// if cannot find class in existing file,
			// recreate one.
			self::init ( self::$dir, self::$ext );
			if (isset ( self::$classFileMapping [$className] ) && file_exists ( self::$classFileMapping [$className] )) {
				require_once self::$classFileMapping [$className];
			} else {
				throw new KClassOrMethodNotFoundException ( 'autoload error: class ' . $className . ' not found' );
			}
		}
	}
}