<?php
spl_autoload_register(function ($class_name) {
    if(file_exists("../app/models/$class_name.php"))
    {
        require_once "../app/models/$class_name.php";
    }
    else if(file_exists("../app/controllers/$class_name.php"))
    {
        require_once "../app/controllers/$class_name.php";
    }
});
function cors(){
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    
    }
    
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        
        if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])){
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        }
        
        if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])){
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        }
        exit(0);
    }
}

cors();

require_once '../app/init.php';
$app = new App;