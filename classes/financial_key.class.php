<?php

require_once("includes/rest.api.php");

class Financial_key extends REST {

    /**
     * Method: customer_account_update
     * Return: true/false
     */
    public function financial_key_insert() {
        
        $customer_id = $this->_request['customerId'];
        $date = date('Y-m-d H:i:s');
        $rand = rand(1000, 9999);

        if ($customer_id != '' && $customer_id > 0) {

            $sql_ = 'SELECT
                     login_id
                  FROM
                     ' . DB_PREFIX . 'financial_key
                  WHERE
                     login_id = "' . $customer_id . '" ';
            $rs = mysql_query($sql_);
            if (mysql_num_rows($rs) > 0) {
                //Update customer

                $sql_ = "SELECT random_number
                     FROM
                     " . DB_PREFIX . "financial_key 
                  WHERE
                       login_id = " . $customer_id;
                $rss=mysql_query($sql_);
                 if (mysql_num_rows($rss)>0){
                 while ($row = mysql_fetch_array($rss)) {
                $rand= $row['random_number'];
                    $mail = $this->send_mail($rand);

                    if ($mail) {
                        $result[] = array('code' => 0, 'message' => 'Financial Key send Your Email');
                    } else {
                        $result[] = array('code' => 0, 'message' => 'Mail Sending Failed');
                    }
                 }} else {
                    $result[] = array('code' => 0, 'message' => 'Database Error Accured');
                }
                $output = $this->response($result, 200);
                return $output;
            } else {
                //Insert customer
                $sql_ = "INSERT INTO " . DB_PREFIX . "financial_key "
                        . "values(NULL,$customer_id,$rand,'" . $date . "')";

                if (mysql_query($sql_)) {
                     $mail = $this->send_mail($rand);
                    if ($mail) {
                        $result[] = array('code' => 0, 'message' => 'Financial Key send Your Email');
                    } else {
                        $result[] = array('code' => 0, 'message' => 'Mail Sending Failed');
                    }
                } else {
                    $result[] = array('code' => 0, 'message' => 'Database Error Accured');
                }
                 $output = $this->response($result, 200);
                return $output;
            }
        }
    }

    public function send_mail($rand) {

        $to = "rashid.cse36@gmail.com";
        $subject = "Financial Key";
        $message = "Your Financial key for this session is ".$rand." \n\r Note: This financial Key will be expired after 15 minutes.";
        $from = "ebanking@mobilebanking.com";
        $headers = "From: $from";
        $status=mail($to, $subject, $message);
        return $status;
    }

}
