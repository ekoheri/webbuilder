<?php
    class registry {
        private static function storedInstance($class_name){
            if(!isset(singleton::getInstance()->$class_name)) {
                return new $class_name;
            }
            return singleton::getInstance()->$class_name;
        }

        public static function library($library_name) {
            require_once 'library/'. $library_name.'.php';
            singleton::getInstance() -> $library_name = 
                self::storedInstance($library_name);
        }

        public static function model($model_name) {
            require_once 'model/'. $model_name.'.php';
            singleton::getInstance() -> $model_name = 
                self::storedInstance($model_name);
        }
    }//end class
?>