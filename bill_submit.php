<?php

require_once("classes/bill_submit.class.php");
$obj = new Bill_submit();
$action = 'bill_transaction';//$_REQUEST['action'];
echo $obj->bill_transaction($action);




