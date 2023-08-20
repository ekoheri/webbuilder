<?php
    class view_library {
        function load($namaView, $dataArr = null){
            if($dataArr !== null)
                extract($dataArr, EXTR_SKIP);
            ob_start();
            include 'view/'.$namaView.'.php';
            $konten = ob_get_contents();
            ob_end_clean();
            return $konten;
        }
    }//end class
?>
