<?php
require_once("classes/configuration.class.php");
$obj = new Configuration();
$action = 'configure_device';//$_REQUEST['action'];
echo $obj->processRequest($action);