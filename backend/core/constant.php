<?php
$protocol = isset($_SERVER['HTTPS']) ? 'https' : 'http';
define('BASE_URL', $protocol."://".$_SERVER['SERVER_NAME'] .":".$_SERVER['SERVER_PORT']);
define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT']);
define('DB_FILE', DIR_ROOT.'/database/db.json');
define('DB_API_KEY', DIR_ROOT.'/database/db_api_key.json');
define('DB_USER', DIR_ROOT.'/database/db_user.json');
define('DIR_ELEMENT_HTML', DIR_ROOT.'/database/elements/html');
define('DIR_ELEMENT_IMAGES', DIR_ROOT.'/database/elements/images');
define('DIR_ASSETS', DIR_ROOT.'/database/elements/assets');
?>