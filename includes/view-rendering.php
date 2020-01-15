<?php

function view($page, $data=null){
    
    // change page name as path
    $_page = str_replace(".", "/", $page);

    // insert page in global data
    $_data = [
        'page' => $_page
    ];

    // merge all passed values
    foreach($data as $key=>$value) {
        $_data[$key] = $value;
    }
    
    return new View($_data);
}