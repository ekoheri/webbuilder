<?php
class admin extends singleton {
    function __construct(){
        parent :: __construct ();

        registry::library('view_library');
        registry::model('admin_model');

        $this->admin_model->init_db();
    }

    function index($active = "navbar"){
        if(!isset($_SESSION['informasi_user'])) {
            header("location: ".BASE_URL."/index.php/admin/login");
            exit;
        }

        $data_content = array();
        $data_elements = $this->admin_model->get_all_elements();
        foreach($data_elements as $key => $value) {
            $data_list = array(
                'element_type' => $key,
                'element_data' => (array)$value
            );
            $data_content[$key] = $this->view_library->load('view_list_elements', $data_list);
            $data_content['active'] = $active;
        }
        $data_assets = array();
        $data_assets['data_assets'] = array_diff(scandir(DIR_ASSETS), array('..', '.'));
        $data_content['list_asset'] = $this->view_library->load('view_list_assets', $data_assets);
        echo $this->view_library->load('view_header');
        echo $this->view_library->load('view_list', $data_content);
        echo $this->view_library->load('view_footer');
    }

    function save_element() {
        if(!isset($_SESSION['informasi_user'])) {
            header("location: ".BASE_URL."/index.php/admin/login");
            exit;
        }
        $element_name = isset($_POST['element_name']) ? $_POST['element_name'] : '';
        $id_element = isset($_POST['id_element']) ? $_POST['id_element'] : '';
        $img_base64 = isset($_POST['img_base64']) ? $_POST['img_base64'] : '';
        $script_html = isset($_POST['script_html']) ? $_POST['script_html'] : '';

        $data = array (
            'element_name' => $element_name,
            'id_element' => $id_element,
            'img_base64' => $img_base64,
            'script_html' => $script_html
        );
        $status = $this->admin_model->save_element($data);
        if($status == true) {
            header("location: ".BASE_URL."/index.php/admin/index/".$element_name);
        }
    }

    function save_asset() {
        $asset = array();
        if(count($_FILES['img_asset']) > 0) {
            $data = array(
                'img_asset' => $_FILES['img_asset']
            );
            
            /*
            echo "<pre>";
            print_r($data);
            echo "</pre>";
            */
            $status = $this->admin_model->save_assets($data);
            if($status == true) {
                header("location: ".BASE_URL."/index.php/admin/index/navbar");
            }
        }
    }

    function delete($type, $id) {
        if(!isset($_SESSION['informasi_user'])) {
            header("location: ".BASE_URL."/index.php/admin/login");
            exit;
        }

        $status = $this->admin_model->delete_element($type, $id);
        if($status == true) {
            header("location: ".BASE_URL."/index.php/admin/index/".$type);
        }
    }

    function delete_asset($id) {
        if(!isset($_SESSION['informasi_user'])) {
            header("location: ".BASE_URL."/index.php/admin/login");
            exit;
        }

        unlink(DIR_ASSETS."/".$id);
        header("location: ".BASE_URL."/index.php/admin/index/navbar");
    }

    function showapikey() {
        if(!isset($_SESSION['informasi_user'])) {
            header("location: ".BASE_URL."/index.php/admin/login");
            exit;
        }
        
        $data_content = array();
        $data_content["api_key"] = $this->admin_model->get_api_key();

        echo $this->view_library->load('view_header');
        echo $this->view_library->load('view_apikey', $data_content);
        echo $this->view_library->load('view_footer');       
    }

    function changetokenapi() {
        if(!isset($_SESSION['informasi_user'])) {
            header("location: ".BASE_URL."/index.php/admin/login");
            exit;
        }
        $token_word = isset($_POST['token_word']) ? $_POST['token_word'] : '';

        $status = $this->admin_model->change_api_key($token_word);
        if($status == true) {
            header("location: ".BASE_URL."/index.php/admin/showapikey");
        }
    }

    function login() {
        echo $this->view_library->load('view_login');
    }

    function submitlogin(){
        $username = isset($_POST['username']) ? $_POST['username'] :'';
        $passwd = isset($_POST['passwd']) ? MD5($_POST['passwd']) :'';

        $status_login = $this->admin_model->get_user_login($username, $passwd);
        if($status_login == true) {
            $_SESSION['informasi_user'] = $username;
            header("location: ".BASE_URL."/index.php/admin/index");
        } else {
            header("location: ".BASE_URL."/index.php/admin/login");
        }
    }

    function logout(){
        session_unset();
        session_destroy();
        header("location: ".BASE_URL."/index.php/admin/login");
    }

    function user() {
        if(!isset($_SESSION['informasi_user'])) {
            header("location: ".BASE_URL."/index.php/admin/login");
            exit;
        }
        $data_content = array();
        $data_content["username"] = $_SESSION['informasi_user'];

        echo $this->view_library->load('view_header');
        echo $this->view_library->load('view_user', $data_content);
        echo $this->view_library->load('view_footer');  
    }

    function changepassword() {
        if(!isset($_SESSION['informasi_user'])) {
            header("location: ".BASE_URL."/index.php/admin/login");
            exit;
        }

        $username = isset($_POST['username']) ? $_POST['username'] :'';
        $passwd_lama = isset($_POST['passwd_lama']) ? MD5($_POST['passwd_lama']) :'';
        $passwd_baru = isset($_POST['passwd_baru']) ? MD5($_POST['passwd_baru']) :'';

        $status = $this->admin_model->change_password($username, $passwd_lama, $passwd_baru);
        echo $status;
        if($status == true) {
            echo '<h1>Sukses mengganti PAssword</h1>';
            echo '<p>Kembali ke halaman <a href="'.BASE_URL.'/index.php/admin/login">login</a></p>';
        }
    }

}
?>