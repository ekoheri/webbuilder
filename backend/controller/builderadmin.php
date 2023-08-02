<?php
class builderadmin {
    private $view;
    function __construct(){
        include "core/helper.php";
        $this->vew = new helper();
    }
    function index()
    {
        echo $this->vew->loadView('view/view_builderadmin.php', null);
    }
    function simpan()
    {
        $jenis_element = isset($_POST['jenis_element']) ? $_POST['jenis_element'] : '';
        $id_element = isset($_POST['id_element']) ? $_POST['id_element'] : '';
        //$img_element = isset($_POST['img_element']) ? $_POST['img_element'] : '';
        $script_html = isset($_POST['script_html']) ? $_POST['script_html'] : '';
        $script_css = isset($_POST['script_css']) ? $_POST['script_css'] : '';
        $script_js = isset($_POST['script_js']) ? $_POST['script_js'] : '';

        $folder = $_SERVER['DOCUMENT_ROOT'].'/elements';

        $ekstensi_diperbolehkan	= array('png','jpg');
        $nama = $_FILES['img_element']['name'];
        $x = explode('.', $nama);
        $ekstensi = strtolower(end($x));
        $ukuran	= $_FILES['img_element']['size'];
        $file_tmp = $_FILES['img_element']['tmp_name'];	
        if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
            if($ukuran < 1044070){
                move_uploaded_file($file_tmp, $folder.'/images/'.$id_element.".".$ekstensi);

                $html_file = fopen($folder.'/html/'.$id_element.".html", "w") or die("Unable to open file HTML");
                fwrite($html_file, $script_html);
                fclose($html_file);

                if($script_css != '') {
                    $css_file = fopen($folder.'/css/'.$id_element.".css", "w") or die("Unable to open file CSS");
                    fwrite($css_file, $script_css);
                    fclose($css_file);
                }

                if($script_js != '') {
                    $js_file = fopen($folder.'/css/'.$id_element.".css", "w") or die("Unable to open file CSS");
                    fwrite($css_file, $script_js);
                    fclose($js_file);
                }
                echo "Sukses menyimpan data ".$id_element;
            } else {
                echo "Ukuran file terlalu besar";
            } 
        } else {
            echo "Ekstensi bukan PNG atau JPG";
        }
 
    }
}
?>