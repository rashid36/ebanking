<?php

require_once("classes/account.class.php");
$obj = new account();
$action = 'customer_account';//$_REQUEST['action'];
echo $obj->customer_account($action);