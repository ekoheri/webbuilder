<?php
session_start();
$mymvc = new index;
$mymvc->run();

class index {
    private $controller = 'admin';
    private $method = 'index';
    private $parameter = array();

    function run(){
        $this->cors();
        $this->routing();
        
        require 'core/singleton.php';
        require 'core/registry.php';
        require 'core/constant.php';

        if(!file_exists('controller/'.$this->controller.'.php'))
            die('File Controller Tidak Ditemukan !');

        require 'controller/'.$this->controller.'.php';
        $obj = new $this->controller;
        if(!method_exists($obj, $this->method))
            die('Method tidak ditemukan !');
        
        define('METHOD_ACTIVE', $this->method);

        call_user_func_array(
            array($obj, $this->method),
            $this->parameter
        );
    }
    function routing(){
        $path = '';
        if(isset($_SERVER['PATH_INFO']))
            $path = $_SERVER['PATH_INFO'];
        $path = trim($path, '/');
        if($path == '')
            return;

        $segmen = explode('/', $path);
        $this->controller = $segmen[0];
        if(sizeof($segmen) > 1)
            $this->method = $segmen[1];
        $this->parameter = array_slice($segmen, 2);
    }
    
    function cors() {
    
        // Allow from any origin
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
            // you want to allow, and if so:
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');    // cache for 1 day
        }
        
        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                // may also be using PUT, PATCH, HEAD etc
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
            
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        
            exit(0);
        }
        
    }
}
?>