<?php
class builderadmin {
    private $view;
    function __construct(){
        include "core/helper.php";
        $this->vew = new helper();
    }
    function index()
    {
        echo $this->vew->loadView('view/view_builderadmin_header.php', null);
        echo $this->vew->loadView('view/view_builderadmin_entry.php', null);
        echo $this->vew->loadView('view/view_builderadmin_footer.php', null);
    }
    function simpan()
    {
        $jenis_element = isset($_POST['jenis_element']) ? $_POST['jenis_element'] : '';
        $id_element = isset($_POST['id_element']) ? $_POST['id_element'] : '';
        $script_html = isset($_POST['script_html']) ? $_POST['script_html'] : '';
        $script_css = isset($_POST['script_css']) ? $_POST['script_css'] : '';
        $script_js = isset($_POST['script_js']) ? $_POST['script_js'] : '';
        $img_element = isset($_FILES['img_element']['name']) ? $_FILES['img_element']['name'] : '';
        
        if($img_element != '') {
            $folder = $_SERVER['DOCUMENT_ROOT'].'/elements';
            $ekstensi_diperbolehkan	= array('png','jpg');
            $x = explode('.', $img_element);
            $ekstensi = strtolower(end($x));
            $ukuran	= $_FILES['img_element']['size'];
            $file_tmp = $_FILES['img_element']['tmp_name'];	
            if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
                if($ukuran < 1044070){
                    move_uploaded_file($file_tmp, $folder.'/images/'.$id_element.".".$ekstensi);

                    $html_file = fopen($folder.'/html/'.$id_element.".html", "w") or die("Unable to open file HTML");
                    fwrite($html_file, $script_html);
                    fclose($html_file);

                    $nama_file_css ='none';
                    if($script_css != '') {
                        $css_file = fopen($folder.'/css/'.$id_element.".css", "w") or die("Unable to open file CSS");
                        fwrite($css_file, $script_css);
                        fclose($css_file);
                        $nama_file_css = $id_element.".css";
                    }

                    $nama_file_js ='none';
                    if($script_js != '') {
                        $js_file = fopen($folder.'/js/'.$id_element.".js", "w") or die("Unable to open file JS");
                        fwrite($css_file, $script_js);
                        fclose($js_file);
                        $nama_file_js = $id_element.".js";
                    }

                    $db_file = file_get_contents($folder.'/db.json');
                    $db_arr = json_decode($db_file, true);

                    $element_baru = array(
                        'id' => $id_element,
                        'image' => $id_element.".".$ekstensi,
                        'css' => $nama_file_css,
                        'js' => $nama_file_js,
                        'html' => $id_element.".html"
                    );
                    array_push($db_arr[$jenis_element], $element_baru);
                    $db_str = json_encode($db_arr);

                    $db_file = fopen($folder."/db.json", "w") or die("Unable to open file HTML");
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
        $db_file = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/elements/db.json');
        $db_arr = json_decode($db_file, true);

        $data["list_element"] = $db_arr;
        echo $this->vew->loadView('view/view_builderadmin_header.php', null);
        echo $this->vew->loadView('view/view_builderadmin_list.php', $data);
        echo $this->vew->loadView('view/view_builderadmin_footer.php', null);
    }
}
?>