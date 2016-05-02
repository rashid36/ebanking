<?php

require_once("includes/rest.api.php");

class Profile extends REST {

    /**
     * Method: processRequest
     * Return: call current function
     */
    public function processRequest($action) {
        $func = strtolower(trim(str_replace("/", "", $action)));
        if ((int) method_exists($this, $func) > 0) {
            $output = $this->$func();
        } else {
            $result[] = array('response' => 'Invalid Request');
            $output = $this->response($result, 404);
        }
        return $output;
    }

    /**
     * Method: customer_account_update
     * Return: true/false
     */
    public function customer_account_update() {
       /* if ($this->get_request_method() != "POST") {
            $result[] = array('response' => 'Invalid Request');
            return $this->response($result, 204);
        }*/
       
                        
         $customer_id=$this->_request['customerId'];
        
            if ($customer_id!='' && $customer_id > 0) {
               
                //Update customer
               $sql_ = 'UPDATE ' . DB_PREFIX . 'customer_login
                    SET
                       username = "' . mysql_real_escape_string($this->_request['userName']) . '"
                  AND
                     password = "' . md5(mysql_real_escape_string($this->_request['password'])) . '"
                
         
                   WHERE
                       login_id = ' . '1'. '';
        if (mysql_query($sql_)) {
            return true;
        } else {
            return false;
        }
                
      
    }
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