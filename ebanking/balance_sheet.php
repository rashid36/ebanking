<?php

require_once("classes/balance_sheet.class.php");
$obj = new Balance_sheet();
$action = 'balance_sheet';//$_REQUEST['action'];
echo $obj->balance_sheet_view($action);




