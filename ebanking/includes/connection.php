<?php

/*$conn = mysql_connect('localhost', 'sketch5_ebank', 'ebanking123');
if (!$conn) {
    die('Could not connect to server ' . mysql_error());
}
mysql_select_db('ebanking', $conn);
//mysql_select_db('sketch5_ebanking', $conn);
define('DB_PREFIX', '');
//define('IMAGE_ROOT_PATH', 'E:/xampp/htdocs/taxi_management/accident_media/images/');
define('IMAGE_ROOT_PATH', 'C:/xampp/htdocs/ebanking/');
define('HELP_LINE_NUMBER','111-111-00');*/
$conn = mysql_connect('localhost', 'root', '');
if (!$conn) {
    die('Could not connect to server ' . mysql_error());
}
mysql_select_db('ebanking', $conn);
define('DB_PREFIX', '');
//define('IMAGE_ROOT_PATH', 'E:/xampp/htdocs/taxi_management/accident_media/images/');
define('IMAGE_ROOT_PATH', 'C:/xampp/htdocs/ebanking/');
define('HELP_LINE_NUMBER','111-111-00');