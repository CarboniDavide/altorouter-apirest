<?php

$directories = ['includes', 'app'];

spl_autoload_register(function($className) {
    
    global $directories;
    
    foreach($directories as $dir){
        autoload($className, BASE_DIR.'/'.$dir);
    }
});


function autoload( $class, $dir ) {

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
            autoload( $class, $dir.'/'.$file);
    }
}