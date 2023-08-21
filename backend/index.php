<?php
session_start();
new index;

class index {
    function __construct() {
        require 'core/cors.php';
        $cors = new cors();
        $cors->set_cors();

        require 'core/router.php';
        $router = new router();
        $router->route();

        require 'core/singleton.php';
        require 'core/registry.php';
        require 'core/constant.php';

        if(!file_exists('controller/'.$router->controller.'.php'))
            die('File Controller Tidak Ditemukan !');

        require 'controller/'.$router->controller.'.php';
        $obj = new $router->controller;
        if(!method_exists($obj, $router->method))
            die('Method tidak ditemukan !');
        
        define('METHOD_ACTIVE', $router->method);

        call_user_func_array(
            array($obj, $router->method),
            $router->parameter
        );
    }
}
?>