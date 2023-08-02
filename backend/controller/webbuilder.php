<?php
class webbuilder {
    private $view;
    function __construct(){
        include "core/helper.php";
        $this->vew = new helper();
    }
    function index(){

        $data = array();
        $data['nama'] = 'Eko Heri';
        echo $this->vew->loadView('view/view_webbuilder.php', $data);
    }
    function elements($parameter)
    {
        $db = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/elements/db.json');
        $json_arr = json_decode($db, true);
        $jenis_element = $parameter;
        for($i = 0; $i < count($json_arr[$jenis_element]); $i++)
        {
            if($json_arr[$jenis_element][$i]['css'] != "none")
            {
                $namafile = $json_arr[$jenis_element][$i]['css'];
                $f = $_SERVER['DOCUMENT_ROOT']  . '/elements/html/'.$namafile;
                $json_arr[$jenis_element][$i]['css'] = htmlentities(file_get_contents($f));
            }
            if($json_arr[$jenis_element][$i]['js'] != "none")
            {
                $namafile = $json_arr[$jenis_element][$i]['js'];
                $f = $_SERVER['DOCUMENT_ROOT']  . '/elements/html/'.$namafile;
                $json_arr[$jenis_element][$i]['css'] = htmlentities(file_get_contents($f));
            }
            $namafile = $json_arr[$jenis_element][$i]['html'];
            $f = $_SERVER['DOCUMENT_ROOT']  . '/elements/html/'.$namafile;
            $json_arr[$jenis_element][$i]['html'] = htmlentities(file_get_contents($f));
        }
        
        echo json_encode($json_arr[$jenis_element]);
    }
}
?>
