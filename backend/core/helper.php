<?php
    class helper {
        function loadView($namaView, $dataArr){
            extract($dataArr, EXTR_SKIP);
            ob_start();
            include $namaView;
            $konten = ob_get_contents();
            ob_end_clean();
            return $konten;
        }
    }//end class
?>
