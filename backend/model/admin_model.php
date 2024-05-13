<?php
class admin_model {
    public function init_db(){
        if(!is_dir(DIR_ROOT .'/database')) {
            mkdir(DIR_ROOT .'/database');
        }

        if(!is_dir(DIR_ROOT.'/database/elements')) {
            mkdir(DIR_ROOT .'/database/elements');
        }

        if(!is_dir(DIR_ROOT .'/database/elements/html')) {
            mkdir(DIR_ROOT .'/database/elements/html');
        }

        if(!is_dir(DIR_ROOT .'/database/elements/images')) {
            mkdir(DIR_ROOT .'/database/elements/images');
        }

        if(!is_dir(DIR_ROOT .'/database/elements/assets')) {
            mkdir(DIR_ROOT .'/database/elements/assets');
        }
            
        if(!file_exists(DB_USER)) {
            $user = array (
                array(
                    "username" => "admin@simetri.io",
                    "passwd" => MD5("bismillah9")
                )
            );

            $dbUserFile = fopen(DB_USER, "w") or die("Unable to open file ".DB_USER);
            fwrite($dbUserFile, json_encode($user));
            fclose($dbUserFile);
        }

        if(!file_exists(DB_FILE)) {
            $db = array(
                "navbar" => array (),
                "header" => array (),
                "content" => array (),
                "footer" => array (),
                "page" => array ()
            );

            $dbFile = fopen(DB_FILE, "w") or die("Unable to open file ".DB_FILE);
            fwrite($dbFile, json_encode($db));
            fclose($dbFile);
        }        
            
        if(!file_exists(DB_API_KEY)) {
            $key = "simetri-api-key-".time();
            $db_api_key = array(
                "api_key" => MD5($key)
            );

            $dbApiKey = fopen(DB_API_KEY, "w") or die("Unable to open file ".DB_API_KEY);
            fwrite($dbApiKey, json_encode($db_api_key));
            fclose($dbApiKey);
        }
    } //end function init_db

    public function get_user_login($username, $passwd) {
        $db_file = file_get_contents(DB_USER);
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
        return $ketemu;
    }

    public function change_password($username, $passwd_lama, $passwd_baru) {
        $db_file = file_get_contents(DB_USER);
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
            //array_replace($db_arr[$i], $pass_baru);
            $db_arr[$i]['username'] = $username;
            $db_arr[$i]['passwd'] = $passwd_baru;

            $dbUserFile = fopen(DB_USER, "w") or die("Unable to open file ".DB_USER);
            fwrite($dbUserFile, json_encode($db_arr));
            fclose($dbUserFile);
        }

        return $ketemu;
    }

    public function get_all_elements() {
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
            foreach($db_arr as $key => $elements) {
                $jumlah = 0;
                if(is_array($db_arr[$key]))
                    $jumlah = count($db_arr[$key]);
                for( $i = 0; $i < $jumlah; $i++) {
                    $fileImg = $db_arr[$key][$i]['image'];
                    $fileHtml = $db_arr[$key][$i]['html'];
                    $db_arr[$key][$i]['image'] = file_get_contents(DIR_ELEMENT_IMAGES.'/'.$fileImg);
                    $db_arr[$key][$i]['html'] = file_get_contents(DIR_ELEMENT_HTML.'/'.$fileHtml);
                }
            }
        }
        return $db_arr;
    }

    public function get_api_key(){
        $api_key = '';
        if(file_exists(DB_API_KEY)) {
            $db_api = file_get_contents(DB_API_KEY);
            $api_arr = json_decode($db_api, true);
            $api_key = $api_arr['api_key'];
        }
        return $api_key;
    }

    public function change_api_key ($token_word) {
        $status = false;
        if(file_exists(DB_API_KEY)) {
            $key = $token_word.time();
            $db_api_key = array(
                "api_key" => MD5($key)
            );

            $dbApiKey = fopen(DB_API_KEY, "w") or die("Unable to open file ".DB_API_KEY);
            fwrite($dbApiKey, json_encode($db_api_key));
            fclose($dbApiKey);
            $status = true;
        }
        return $status;
    }

    public function save_element($data) {
        $status = false;
        if($data['img_base64'] != '')
        {
            $img_file = fopen(DIR_ELEMENT_IMAGES.'/'.$data['id_element'].".txt", "w") or die("Unable to open file ".$data['id_element'].".txt");
            fwrite($img_file, $data['img_base64']);
            fclose($img_file);

            $html_file = fopen(DIR_ELEMENT_HTML.'/'.$data['id_element'].".html", "w") or die("Unable to open file ".$data['id_element'].".html");
            fwrite($html_file, $data['script_html']);
            fclose($html_file);

            $db_file = file_get_contents(DB_FILE);
            $db_arr = json_decode($db_file, true);

            $element_entry = array(
                'id' => $data['id_element'],
                'image' => $data['id_element'].".txt",
                'html' => $data['id_element'].".html"
            );

            $i = 0;
            $ketemu = false;
            while($i < count($db_arr[$data['element_name']]) && $ketemu == false) {
                if($data['id_element'] == $db_arr[$data['element_name']][$i]['id']) {
                    $ketemu = true;
                } else {
                    $i++;
                }
            }
            if($ketemu == true) {
                //update db
                array_replace($db_arr[$data['element_name']][$i], $element_entry);
            } else {
                //insert db
                array_push($db_arr[$data['element_name']], $element_entry);     
            }
            $db_str = json_encode($db_arr);

            $db_file = fopen(DB_FILE, "w") or die("Unable to open file HTML");
            fwrite($db_file, $db_str);
            fclose($db_file);

            $status = true;
        } else {
            $status = false;
        }
        return $status;
    }//end save_element

    public function save_assets($data) {
        $status = false;
        $jumlahFile = count($data['img_asset']['name']);
        if($jumlahFile > 0) {
            for ($i = 0; $i < $jumlahFile; $i++) {
                $namaFile = $data['img_asset']['name'][$i];
                $lokasiTmp = $data['img_asset']['tmp_name'][$i];
                $lokasiBaru = DIR_ASSETS."/".$namaFile;
                $prosesUpload = move_uploaded_file($lokasiTmp, $lokasiBaru);
                if ($prosesUpload) {
                    $status = true;
                } else {
                    echo "Gagal upload! ke ".$lokasiBaru;
                    $status = false;
                }
            }
        } else {
            echo "Jumlah file kosong!";
            $status = false;
        }
        return $status;
    }

    public function delete_element($type, $id) {
        $status = false;

        $db_file = file_get_contents(DB_FILE);
        $db_arr = json_decode($db_file, true);
        $i = 0;
        $ketemu = false;
        while($i < count($db_arr[$type]) && $ketemu == false) {
            if($id == $db_arr[$type][$i]['id']) {
                $ketemu = true;
            } else {
                $i++;
            }
        }
        if($ketemu == true) {
            unlink(DIR_ELEMENT_IMAGES.'/'.$id.".txt");
            unlink(DIR_ELEMENT_HTML.'/'.$id.".html");

            unset($db_arr[$type][$i]);

            $db_str = json_encode($db_arr);
            $db_file = fopen(DB_FILE, "w") or die("Unable to open file HTML");
            fwrite($db_file, $db_str);
            fclose($db_file);

            $status = true;
        }
        return $status;
    }//end delete_element
}//end class
?>
