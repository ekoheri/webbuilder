<?php
class admin {
    private $view;
    private $baseurl;
    private $dirRoot;
    private $dirElementHtml;
    private $dirElementImage;

    private $dbFile;
    private $dbUserFile;
    private $dbApiKey;

    function __construct(){
        include "core/helper.php";
        $this->vew = new helper();
        $this->baseurl = "http://".$_SERVER['SERVER_NAME'] .":".$_SERVER['SERVER_PORT']."/index.php/admin/";

        $this->dirRoot = $_SERVER['DOCUMENT_ROOT']; 

        $this->dbFile = $this->dirRoot .'/database/db.json';
        $this->dbUserFile = $this->dirRoot .'/database/db_user.json';
        $this->dbApiKey = $this->dirRoot .'/database/db_api_key.json';

        $this->dirElementHtml =  $this->dirRoot .'/database/elements/html/';
        $this->dirElementImage =  $this->dirRoot .'/database/elements/images/';

        $this->init();
    }

    function index(){
        if(!isset($_SESSION['informasi_user'])) {
            header("location: ".$this->baseurl."login");
            exit;
        }
        $db_file = file_get_contents($this->dbFile);
        $db_arr = json_decode($db_file, true);

        $jumlah_data = array();
        foreach($db_arr as $key => $value) {
            $jumlah_data[$key] = count ($value);
        }

        //print_r($jumlah_data);
        $data_header = array();
        $data_header["baseurl"] = $this->baseurl;
        $data_content = array();
        $data_content["jumlah_data"] = $jumlah_data;

        echo $this->vew->loadView('view/view_header.php', $data_header);
        echo $this->vew->loadView('view/view_entry.php', $data_content);
        echo $this->vew->loadView('view/view_footer.php', null);
    }

    function simpan() {
        if(!isset($_SESSION['informasi_user'])) {
            header("location: ".$this->baseurl."login");
            exit;
        }
        $jenis_element = isset($_POST['jenis_element']) ? $_POST['jenis_element'] : '';
        $id_element = isset($_POST['id_element']) ? $_POST['id_element'] : '';
        $img_element = isset($_FILES['img_element']['name']) ? $_FILES['img_element']['name'] : '';
        $script_html = isset($_POST['script_html']) ? $_POST['script_html'] : '';
        
        if($img_element != '') {
            $ekstensi_diperbolehkan	= array('png','jpg');
            $x = explode('.', $img_element);
            $ekstensi = strtolower(end($x));
            $ukuran	= $_FILES['img_element']['size'];
            $file_tmp = $_FILES['img_element']['tmp_name'];	
            if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
                if($ukuran < 1044070){
                    move_uploaded_file($file_tmp, $this->dirElementImage.$id_element.".".$ekstensi);

                    $html_file = fopen($this->dirElementHtml.$id_element.".html", "w") or die("Unable to open file HTML");
                    fwrite($html_file, $script_html);
                    fclose($html_file);

                    $db_file = file_get_contents($this->dbFile);
                    $db_arr = json_decode($db_file, true);

                    $element_entry = array(
                        'id' => $id_element,
                        'image' => $id_element.".".$ekstensi,
                        'html' => $id_element.".html"
                    );

                    $i = 0;
                    $ketemu = false;
                    while($i < count($db_arr[$jenis_element]) && $ketemu == false) {
                        if($id_element == $db_arr[$jenis_element][0]['id']) {
                            $ketemu = true;
                        } else {
                            $i++;
                        }
                    }
                    if($ketemu == true) {
                        //update db
                        array_replace($db_arr[$jenis_element][$i], $element_entry);
                    } else {
                       //insert db
                       array_push($db_arr[$jenis_element], $element_entry);     
                    }
                    $db_str = json_encode($db_arr);

                    $db_file = fopen($this->dbFile, "w") or die("Unable to open file HTML");
                    fwrite($db_file, $db_str);
                    fclose($db_file);

                    echo "<p>Sukses menyimpan data ".$id_element."</p>";
                } else {
                    echo "<p>Ukuran file terlalu besar</p>";
                } 
            } else {
                echo "<p>Ekstensi bukan PNG atau JPG</p>";
            }

            echo "<p><a href=\"index\">Kembali ke halaman entry</a></p>";
        }   
    }

    function list(){
        if(!isset($_SESSION['informasi_user'])) {
            header("location: ".$this->baseurl."login");
            exit;
        }
        $db_file = file_get_contents($this->dbFile);
        $db_arr = json_decode($db_file, true);

        $data_header = array();
        $data_header["baseurl"] = $this->baseurl;

        $data_list["list_element"] = $db_arr;
        echo $this->vew->loadView('view/view_header.php', $data_header);
        echo $this->vew->loadView('view/view_list.php', $data_list);
        echo $this->vew->loadView('view/view_footer.php', null);
    }

    function ShowApiKey() {
        if(!isset($_SESSION['informasi_user'])) {
            header("location: ".$this->baseurl."login");
            exit;
        }
        
        $api_key = '';
        if(file_exists($this->dbApiKey)) {
            $db_api = file_get_contents($this->dbApiKey);
            $api_arr = json_decode($db_api, true);
            $api_key = $api_arr['api_key'];
        }

        $data_header = array();
        $data_header["baseurl"] = $this->baseurl;
        $data_content = array();
        $data_content["api_key"] = $api_key;
        echo $this->vew->loadView('view/view_header.php', $data_header);
        echo $this->vew->loadView('view/view_apikey.php', $data_content);
        echo $this->vew->loadView('view/view_footer.php', null);        
    }

    function login() {
        echo $this->vew->loadView('view/view_login.php', null);
    }

    function submitlogin(){
        $username = isset($_POST['username']) ? $_POST['username'] :'';
        $passwd = isset($_POST['passwd']) ? MD5($_POST['passwd']) :'';

        echo $passwd;

        $db_file = file_get_contents($this->dbUserFile);
        $db_arr = json_decode($db_file, true);
        $i = 0;
        $ketemu = false;
        while($i < count($db_arr) && $ketemu == false) {
            if($username == $db_arr[$i]['username'] && $passwd == $db_arr[$i]['passwd']) {
                $ketemu = true;
            } else {
                $i++;
            }
        }
        if($ketemu == true) {
            $_SESSION['informasi_user'] = $username;
            header("location: ".$this->baseurl."index");
        } else {
            header("location: ".$this->baseurl."login");
        }
    }

    function logout(){
        session_unset();
        session_destroy();
        header("location: ".$this->baseurl."login");
    }

    function Pengguna() {
        if(!isset($_SESSION['informasi_user'])) {
            header("location: ".$this->baseurl."login");
            exit;
        }
        $data_header = array();
        $data_header["baseurl"] = $this->baseurl;
        $data_content = array();
        $data_content["baseurl"] = $this->baseurl;
        $data_content["username"] = $_SESSION['informasi_user'];

        echo $this->vew->loadView('view/view_header.php', $data_header);
        echo $this->vew->loadView('view/view_user.php', $data_content);
        echo $this->vew->loadView('view/view_footer.php', null);
    }

    function GantiPassword() {
        if(!isset($_SESSION['informasi_user'])) {
            header("location: ".$this->baseurl."login");
            exit;
        }

        $username = isset($_POST['username']) ? $_POST['username'] :'';
        $passwd_lama = isset($_POST['passwd_lama']) ? MD5($_POST['passwd_lama']) :'';
        $passwd_baru = isset($_POST['passwd_baru']) ? MD5($_POST['passwd_baru']) :'';

        $db_file = file_get_contents($this->dbUserFile);
        $db_arr = json_decode($db_file, true);
        $i = 0;
        $ketemu = false;

        while($i < count($db_arr) && $ketemu == false) {
            if($username == $db_arr[$i]['username'] && $passwd_lama == $db_arr[$i]['passwd']) {
                $ketemu = true;
            } else {
                $i++;
            }
        }
        if($ketemu == true) {
            echo "<pre>";
            print_r($db_arr);
            echo "</pre>";

            //array_replace($db_arr[$i], $pass_baru);
            $db_arr[$i]['username'] = $username;
            $db_arr[$i]['passwd'] = $passwd_baru;
            
            echo "<pre>";
            print_r($db_arr);
            echo "</pre>";

            $dbUserFile = fopen($this->dbUserFile, "w") or die("Unable to open file User");
            fwrite($dbUserFile, json_encode($db_arr));
            fclose($dbUserFile);

            echo "<h5>Sukses merubah Password</h5>";
            echo "<p><a href=\"".$this->baseurl."index\">Kembali ke halaman depan</a></p>";
        }
    }

    private function init(){
        if(!is_dir($this->dirRoot .'/database')) {
            mkdir($this->dirRoot .'/database');
        }

        if(!is_dir($this->dirRoot .'/database/elements')) {
            mkdir($this->dirRoot .'/database/elements');
        }

        if(!is_dir($this->dirRoot .'/database/elements/html')) {
            mkdir($this->dirRoot .'/database/elements/html');
        }

        if(!is_dir($this->dirRoot .'/database/elements/images')) {
            mkdir($this->dirRoot .'/database/elements/images');
        }
            
        if(!file_exists($this->dbUserFile)) {
            $user = array (
                array(
                    "username" => "admin@gadawangi.com",
                    "passwd" => MD5("admin123")
                )
            );

            $dbUserFile = fopen($this->dbUserFile, "w") or die("Unable to open file HTML");
            fwrite($dbUserFile, json_encode($user));
            fclose($dbUserFile);
        }

        if(!file_exists($this->dbFile)) {
            $db = array(
                "navbar" => array (),
                "header" => array (),
                "content" => array (),
                "footer" => array (),
                "page" => array ()
            );

            $dbFile = fopen($this->dbFile, "w") or die("Unable to open file HTML");
            fwrite($dbFile, json_encode($db));
            fclose($dbFile);
        }        
            
        if(!file_exists($this->dbApiKey)) {
            $key = "gadawangi-api-key-".time();
            $db_api_key = array(
                "api_key" => MD5($key)
            );

            $dbApiKey = fopen($this->dbApiKey, "w") or die("Unable to open file HTML");
            fwrite($dbApiKey, json_encode($db_api_key));
            fclose($dbApiKey);
        }
    } //end function init
}
?>