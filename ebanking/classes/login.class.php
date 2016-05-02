<?php

require_once("includes/rest.api.php");

class Login extends REST {

    /**
     * Method: processRequest
     * Return: call current function
     */
    public function processRequest($action) {
        $func = strtolower(trim(str_replace("/", "", $action)));
        if ((int) method_exists($this, $func) > 0) {
            $output = $this->$func();
        } else {
            $result[] = array('response' => 'Invalid Requestddddd');
            $output = $this->response($result, 404);
        }
        return $output;
    }

    /**
     * Method: driver_login
     * Return: true/false
     */
    public function customer_login() {
        if ($this->get_request_method() != "POST") {
            $result[] = array('response' => 'Invalid Request');
            return $this->response($result, 204);
        }
        $sql_ = 'SELECT
                     *
                  FROM
                     ' . DB_PREFIX . 'customer_login 
                         WHERE
                     username = "' . mysql_real_escape_string($this->_request['userName']) . '"
                  AND
                     password = "' . md5(mysql_real_escape_string($this->_request['password'])) . '"
                  LIMIT 1
         ';

         $rs = mysql_query($sql_);
         if (mysql_num_rows($rs)>0){
             $row = mysql_fetch_array($rs);           
             $is_blocked = $row['account_status'];
             $login_id = $row['login_id'];
            // $customerName=$row['username'];
             $accountStatus=$row['account_status'];
             $message=$row['status_msg'];
            $customerName=$row['name'];
                 $driverSettings = array('customerId'=>$login_id,'customerName'=>$customerName,'accountStatus'=>$accountStatus,'message'=>$message);
                 $result[] = array('code' => 1, 'message' => 'Success','response'=>$driverSettings);
             
         } else {            
             $result[] = array('code' => 0, 'message' => 'Invalid username or password');
         }
        $output = $this->response($result, 200);
        return $output;
    }
    
    /**
     * Method: getDriverSettings
     * Params: $driverId
     * Returns: data
     */
    public function getDriverSettings($driverId){
        $sql_= 'SELECT permanent_track,logout,monitoring_time FROM ' . DB_PREFIX . 'driver_settings WHERE driver_id = '.$driverId.' AND status = 1 LIMIT 1';
        $rs = mysql_query($sql_);
        if (mysql_num_rows($rs)>0){
            $row = mysql_fetch_array($rs);
            $result['driverId'] = $driverId;
            $result['permanentTrack'] = $row['permanent_track'];
            $result['logout'] = $row['logout'];
            $result['monitoringtime'] = $row['monitoring_time'];
            return $result;
        } else {
            return $result = array('response' => 'No Record Found.');
        }      
    }

}
