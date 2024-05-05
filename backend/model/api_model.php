<?php
class api_model {
    public function get_api_key(){
        $api_key = '';
        if(file_exists(DB_API_KEY)) {
            $db_api = file_get_contents(DB_API_KEY);
            $api_arr = json_decode($db_api, true);
            $api_key = $api_arr['api_key'];
        }
        return $api_key;
    }

    public function get_all_element() {
        $db_arr = array(
            "navbar" => array(),
            "header" => array(),
            "content" => array(),
            "footer" => array(),
            "page" => array()
        );

        if(file_exists(DB_FILE)) {
            $db_file = file_get_contents(DB_FILE);
            $db_arr = json_decode($db_file, true);
        }
        return $db_arr;
    }

    public function get_single_element($element_name, $page) {
        $json_arr [$element_name] = array();

        if(file_exists(DB_FILE)) {
            $db = file_get_contents(DB_FILE);
            $json_arr = json_decode($db, true);
            for($i = 0; $i < count($json_arr[$element_name]); $i++)
            {
                //replace URL Image
                $file_name = $json_arr[$element_name][$i]['image'];
                $f = DIR_ELEMENT_IMAGES.'/'.$file_name;
                $json_arr[$element_name][$i]['image'] = file_get_contents($f);

                //replace HTML
                $file_name = $json_arr[$element_name][$i]['html'];
                $f = DIR_ELEMENT_HTML.'/'.$file_name;
                $json_arr[$element_name][$i]['html'] = htmlentities($this->SearchImageTag(file_get_contents($f)));
            }
        }

        // The page to display (Usually is received in a url parameter)
        $page = intval($page);

        // The number of records to display per page
        $page_size = 5;

        // Calculate total number of records, and total number of pages
        $total_records = count($json_arr[$element_name]);
        $total_pages   = ceil($total_records / $page_size);

        // Validation: Page to display can not be greater than the total number of pages
        if ($page > $total_pages) {
            $page = $total_pages;
        }

        // Validation: Page to display can not be less than 1
        if ($page < 1) {
            $page = 1;
        }

        // Calculate the position of the first record of the page to display
        $offset = ($page - 1) * $page_size;

        // Get the subset of records to be displayed from the array
        $data = array(
            'element_name' => $element_name,
            'page' => $page,
            'total_pages' => $total_pages,
            'data' => array_slice($json_arr[$element_name], $offset, $page_size) 
        );
        
        //return to controller
        return json_encode($data);
    }

    //Penambahan fasiltas assets
    function SearchImageTag($html) {
        $pattern = '/assets\/([^"\' ]+\.\w{2,4})["\']/';

        preg_match_all($pattern, $html, $matches);
        for ($i = 0; $i < count($matches[0]); $i++) {
            $html = str_replace('assets/'.$matches[1][$i], $this->ConvertImageToBase64($matches[1][$i]), $html);
        }

        return $html;
    }

    function ConvertImageToBase64($filename) {
        $image = file_get_contents(DIR_ASSETS.'/'.$filename);
        $data = base64_encode($image);
        return 'data:image/png;base64,'.$data; 
    }
}//end class
?>