<?php

require_once("classes/login.class.php");
$obj = new Login();
$action = 'customer_login';//$_REQUEST['action'];
echo $obj->processRequest($action);

/*
require_once("classes/financial_key.class.php");
$obj = new Financial_key();
$action = 'financial_key_insert';//$_REQUEST['action'];
echo $obj->financial_key_insert($action);
 
 */


