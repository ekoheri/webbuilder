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
        $data_header = array();
        $data_header["baseurl"] = $this->baseurl;
        echo $this->vew->loadView('view/view_header.php', $data_header);
        echo $this->vew->loadView('view/view_entry.php', null);
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

    function login() {
        echo $this->vew->loadView('view/view_login.php', null);
    }

    function submitlogin(){
        $username = isset($_POST['username']) ? $_POST['username'] :'';
        $passwd = isset($_POST['passwd']) ? $_POST['passwd'] :'';

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

    private function init(){
        if(!is_dir($this->dirRoot .'/database')) {
            mkdir($this->dirRoot .'/database');
            mkdir($this->dirRoot .'/database/elements');
            mkdir($this->dirRoot .'/database/elements/html');
            mkdir($this->dirRoot .'/database/elements/images');

            $user = array (
                array(
                    "username" => "admin@gadawangi.com",
                    "passwd" => "admin123"
                )
            );

            $dbUserFile = fopen($this->dbUserFile, "w") or die("Unable to open file HTML");
            fwrite($dbUserFile, json_encode($user));
            fclose($dbUserFile);

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

            $db_api_key = array(
                "api_key" => MD5("gadawangi-apy-key")
            );

            $dbApiKey = fopen($this->dbApiKey, "w") or die("Unable to open file HTML");
            fwrite($dbApiKey, json_encode($db_api_key));
            fclose($dbApiKey);
        }
    }
}
?>