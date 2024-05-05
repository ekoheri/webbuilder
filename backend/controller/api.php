<?php
class api extends singleton {
    function __construct(){
        parent :: __construct ();

        registry::library('view_library');
        registry::model('api_model');
    }

    function index(){
        $db_arr = $this->api_model->get_all_element();
        $data_list["list_element"] = $db_arr;
        echo $this->view_library->load('view_api', $data_list);
    }

    function elements($parameter, $page=1)
    {
        /*$api_key =  $this->api_model->get_api_key();
        $header = getallheaders();

        if(!isset($header['api-key'])) {
            http_response_code(401);
            echo "<h1>401 : Access denied, because API key is empty</h1>";
            exit;
        } else if($header['api-key'] !== $api_key){
            http_response_code(401);
            echo "<h1>401 : Access denied, because API key is unknown</h1>";
            exit;
        }*/
        
        echo $this->api_model->get_single_element($parameter, $page);
    }
}
?>
