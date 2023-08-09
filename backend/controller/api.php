<?php
class api {
    private $baseurl;
    private $dirRoot;
    private $dbFile;
    private $dbApiKey;
    private $dbExists = false;
    private $api_key = ''; 
    private $urlElementHtml;
    private $dirElementImages;
    
    function __construct(){
        $this->baseurl = "http://".$_SERVER['SERVER_NAME'] .":".$_SERVER['SERVER_PORT'];

        $this->dirRoot = $_SERVER['DOCUMENT_ROOT']; 

        $this->dbFile = $this->dirRoot .'/database/db.json';

        $this->dbApiKey = $this->dirRoot .'/database/db_api_key.json';
        
        $this->dirElementHtml =  $this->dirRoot .'/database/elements/html/';
        
        $this->urlImages =  $this->baseurl .'."/database/elements/images/';

        if(file_exists($this->dbFile))
            $this->dbExists = true;

        $this->api_key = '';
        if(file_exists($this->dbApiKey)) {
            $db_api = file_get_contents($this->dbApiKey);
            $api_arr = json_decode($db_api, true);
            $this->api_key = $api_arr['api_key'];
        }
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
        $data_list["api_key"] = $this->api_key;
        echo $view->loadView('view/view_api.php', $data_list);
    }

    function elements($parameter)
    {
        $header = getallheaders();
        //echo $header['api-key'];
        if(!isset($header['api-key'])) {
            http_response_code(401);
            exit;
        } else if($header['api-key'] !== $this->api_key){
            http_response_code(401);
            exit;
        }

        $json_arr [$parameter] = array();

        if($this->dbExists) {
            $db = file_get_contents($this->dbFile);
            $json_arr = json_decode($db, true);
            for($i = 0; $i < count($json_arr[$parameter]); $i++)
            {
                //replace URL Image
                $json_arr[$parameter][$i]['image'] = $this->urlImages.$json_arr[$parameter][$i]['image'];

                //replace HTML
                $namafile = $json_arr[$parameter][$i]['html'];
                $f = $this->dirElementHtml.$namafile;
                $json_arr[$parameter][$i]['html'] = htmlentities(file_get_contents($f));
            }
        }
        echo json_encode($json_arr[$parameter]);
    }
}
?>
