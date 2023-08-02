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
            $base_url_img = "http://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT']."/elements/images/";
            $json_arr[$jenis_element][$i]['image'] = $base_url_img.$json_arr[$jenis_element][$i]['image'];

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

    function download()
    {
        $requestElement = file_get_contents('php://input');
        $json_arr = json_decode($requestElement, true);
        
        $str = '<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>';
$str .= "\r\n";
        for($i = 0; $i < count($json_arr); $i++)
        {
            $namafile = $json_arr[$i]['elemen'].".html";
            $f = $_SERVER['DOCUMENT_ROOT'] . '/elements/html/'.$namafile;
            $str .= file_get_contents($f);
            $str .= "\r\n";
        }
        
        $str .= '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>';
        
        $mimeType = 'text/plain';
        $fileSize = strlen ( $str );
        $file_name = "index.html";
        header("Content-Type: $mimeType");
        header("Content-Length: $fileSize");
        header("Content-Disposition: attachment; filename=$file_name");
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        echo $str;
        exit;
    }
}
?>
