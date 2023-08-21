<?php
class router {
    public $controller = "api";
    public $method = "index";
    public $parameter = array();

    public function route(){
        $path = '';
        if(isset($_SERVER['PATH_INFO']))
            $path = $_SERVER['PATH_INFO'];

        $path = trim($path, '/');
        if($path == '') return;

        $segmen = explode('/', $path);
        $this->controller = $segmen[0];
        if(sizeof($segmen) > 1)
            $this->method = $segmen[1];
        $this->parameter = array_slice($segmen, 2);
    }
}
?>