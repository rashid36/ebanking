<?php

require_once("classes/mobile_load_history.class.php");
$obj = new mobile_load_history();
$action = 'mobile_load_view';//$_REQUEST['action'];
echo $obj->mobile_load_view($action);




