<?php

define('PATH_ROOT', $_SERVER['DOCUMENT_ROOT']);

class Load{

    private static $directories = ['includes', 'controllers', 'config', 'models'];

    public static function All(){
        self::Shared();
        self::Classes();
    }

    public static function Classes(){
        spl_autoload_register(function($className) {
            foreach(self::$directories as $dir){
                self::autoload($className, PATH_ROOT.'/'.$dir);
            }
        });
    }

    public static function Shared(){
        include_once PATH_ROOT . '/includes/rb-mysql.php';
    }

    private static function autoload( $class, $dir ) {

        foreach ( scandir( $dir ) as $file ) {

            // is php file?
            if ( substr( $file, 0, 2 ) !== '._' && preg_match( "/.php$/i" , $file ) ) {

                // filename matches class?
                if ( str_replace( '.php', '', $file ) == $class || str_replace( '.class.php', '', $file ) == $class ) {
                    include_once $dir.'/'.$file;
                    if (method_exists($class,'init')){
                        $class::init();
                    }
                }
            }

            // is directory?
            if ( is_dir( $dir.'/'.$file ) && substr( $file, 0, 1 ) !== '.' )
                self::autoload( $class, $dir.'/'.$file);
        }
    }

}