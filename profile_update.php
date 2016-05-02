<?php

require_once("classes/profile.class.php");
$obj = new profile();
$action = 'customer_account_update';//$_REQUEST['action'];
echo $obj->customer_account_update($action);