<?php

require_once("classes/easy_load.class.php");
$obj = new Easy_load();
$action = 'mobile_transaction';//$_REQUEST['action'];
echo $obj->mobile_transaction($action);




