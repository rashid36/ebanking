<?php

require_once("includes/rest.api.php");

class Configuration extends REST {

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
     * Method: is_device_exists
     * Params: $device_id
     * Return: true/false
     */
    public function is_device_exists($device_id) {
        $sql_ = 'SELECT
                    device_id
                 FROM
                    ' . DB_PREFIX . 'device_info
                 WHERE
                    device_id = ' . $device_id . ''
        ;

        $rs = mysql_query($sql_);

        if (mysql_num_rows($rs) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method: configure_device
     * Params: $post
     * Retrun: response
     */
    public function configure_device() {

        if ($this->get_request_method() != "POST") {
            $result[] = array('response' => 'Invalid Request');
            return $this->response($result, 204);
        }

        //Check device already exists
        $isDeviceExists = $this->is_device_exists($this->_request['deviceId']);
        $deviceConstants = $this->getDeviceConstant();
        if ($isDeviceExists) { //update Device
            $sql_update = 'UPDATE ' . DB_PREFIX . 'device_info
					SET
						vendor_id = "' . mysql_real_escape_string($this->_request['VendorId']) . '",
						os_name = "' . mysql_real_escape_string($this->_request['osName']) . '",
						status = "2"
					WHERE
						device_id = "' . mysql_real_escape_string($this->_request['deviceId']) . '"
					';
            if (mysql_query($sql_update)) {
                $result[] = array('code' => 1, 'message' => 'Device Updated','response'=>$deviceConstants);
            } else {
                $sql_error = mysql_error();
                $result[] = array('code' => 0, 'message' => $sql_error);
            }
        } else {//Insert Device
            $sql_insert = 'INSERT INTO 
                                '. DB_PREFIX . 'device_info 
                                    (
                                        vendor_id,
                                        os_name,
                                        status
                                     )
                                   VALUES
                                    (
                                         "' . mysql_real_escape_string($this->_request['VendorId']) . '",
                                         "' . mysql_real_escape_string($this->_request['osName']) . '",
                                         "0"
                                     )';

            if (mysql_query($sql_insert)) {
                $result[] = array('code' => 1, 'message' => 'Device added successfully','response'=>$deviceConstants);
            } else {
                $sql_error = mysql_error();
                $result[] = array('code' => 0, 'message' => $sql_error);
            }
        }
        $output = $this->response($result, 200);
        return $output;
    }
    
    /**
     * Method: getDeviceConstant
     * Return: array
     */
    public function getDeviceConstant(){
        $sql_ = 'SELECT
                    *
                 FROM
                    '.DB_PREFIX.'device_constants
                 WHERE
                    status = 1
                    LIMIT 1
                ';
        $rs = mysql_query($sql_);
        if (mysql_num_rows($rs)>0){
            while ($row = mysql_fetch_array($rs)) {
                $result['baseURL'] = $row['base_url'];
                $result['logo'] = $row['logo_path'];
                $result['companyName'] = $row['company_name'];
                $result['titleBackgroundColor'] = $row['title_bg_color'];
                $result['titleForgroundColor'] = $row['title_fg_color'];
                $result['mainBackgroundColor'] = $row['main_bg_color'];
                $result['mainForgroundColor'] = $row['main_fg_color'];
            }
        }else{
            $result = array('response' => 'No Record Found.');
        }
        return $result;
    }

}
