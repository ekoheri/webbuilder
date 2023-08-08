<?php
class api {
    private $dirRoot;
    private $dbFile;
    private $dbExists = false; 
    private $dirElements;
    function __construct(){
        $this->dirRoot = $_SERVER['DOCUMENT_ROOT']; 
        $this->dbFile = $this->dirRoot .'/database/db.json';
        $this->dirElements =  $this->dirRoot .'/database/elements/';
        if(file_exists($this->dbFile))
            $this->dbExists = true;
    }
    function index(){
        include "core/helper.php";
        $view = new helper();
        
        $db_arr = array(
            "navbar" => array(),
            "header" => array(),
            "content" => array(),
            "footer" => array(),
            "page" => array()
        );

        if($this->dbExists) {
            $db_file = file_get_contents($this->dbFile);
            $db_arr = json_decode($db_file, true);
        }

        $data_list["list_element"] = $db_arr;
        echo $view->loadView('view/view_api.php', $data_list);
    }

    function elements($parameter)
    {
        $json_arr[$parameter] = array(
            'id' => '',
            'image' => '',
            'html' => ''
        );

        $jenis_element = $parameter;
        if($this->dbExists) {
            $db = file_get_contents($this->dbFile);
            $json_arr = json_decode($db, true);
            
            for($i = 0; $i < count($json_arr[$jenis_element]); $i++)
            {
                //replace URL Image
                $base_url_img = "http://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT']."/elements/images/";
                $json_arr[$jenis_element][$i]['image'] = $base_url_img.$json_arr[$jenis_element][$i]['image'];

                //replace HTML
                $namafile = $json_arr[$jenis_element][$i]['html'];
                $f = $this->dirElements.$namafile;
                $json_arr[$jenis_element][$i]['html'] = htmlentities(file_get_contents($f));
            }
        }
        echo json_encode($json_arr[$jenis_element]);
    }
}
?>
