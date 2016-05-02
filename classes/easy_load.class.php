<?php

require_once("includes/rest.api.php");

class Easy_load extends REST {

    /**
     * Method: customer_account_update
     * Return: true/false
     */
    public function mobile_transaction() {
        if ($this->get_request_method() != "POST") {
            $result[] = array('response' => 'Invalid Request');
            return $this->response($result, 204);
        }


        $customer_id= $this->_request['customerId'];
         $financial_key= $this->_request['financial_key'];
          $networkId= $this->_request['networkId'];
           $mobile= $this->_request['mobile'];
           $ref_no= (isset($this->_request['ref_no']))?$this->_request['ref_no']:'0';
            $amount= $this->_request['amount'];
        
      $mobileNo=  strlen($mobile);
        if($mobileNo>11){
            $result[] = array('code' => 0, 'message' => 'Invalid Mobile Number');
                $output = $this->response($result, 200);
                return $output;
        }
        
       

       
        $date = date('Y-m-d H:i:s');
        // $rand=rand(10000, 99999);

        if (isset($customer_id) && $customer_id > 0) {

            //chek customer

            $sql_ = "SELECT
                             *
                  FROM
                    " . DB_PREFIX . " financial_key
                  WHERE
                     login_id ='$customer_id'  AND  random_number='$financial_key' AND c_date > NOW() - INTERVAL 15 MINUTE";
            $rs = mysql_query($sql_);
            if (mysql_num_rows($rs) > 0) {
                //Chek amount

                $resp=$this->chek_amount($amount, $customer_id);
                return $resp; 
               
            } else {
                $result[] = array('code' => 0, 'message' => 'Invalid Financial Key or Expired. Please Re-generate financial key');
                $output = $this->response($result, 200);
                return $output;
            }
        } else {
            $result[] = array('code' => 0, 'message' => 'Not Found Such User');
            $output = $this->response($result, 200);
            return $output;
        }
       // return $this->response($result, 200);
    }

    public function chek_amount($amount, $customer_id) {
         $networkId = $this->_request['networkId'];
         $ref_no= (isset($this->_request['ref_no']))?$this->_request['ref_no']:'0';
         $mobileNo = $this->_request['mobile'];
       $date = date('Y-m-d H:i:s');
       
        $sql_ = "SELECT
                             *
                  FROM
                    " . DB_PREFIX . " current_account
                  WHERE
                     login_id ='$customer_id'";
        $rs = mysql_query($sql_);
        if (mysql_num_rows($rs) > 0) {
            //Chek amount
            $row = mysql_fetch_array($rs);
            $c_amount = $row['current_balance'];
            if ($c_amount>=$amount) {
                $remaining = $c_amount - $amount;
                //// update amount

                $sql_ = "UPDATE " . DB_PREFIX . "current_account
                    SET
                       current_balance =  " . $remaining . " 
                 
                   WHERE
                       login_id = " . $customer_id;
                mysql_query($sql_);
                
                
                  /*  ///// Insert Transaction
                    $sql_ = "INSERT INTO " . DB_PREFIX . "load_draw_inbox "
                         . "values(NULL,$customer_id,$networkId,$mobileNo,$amount,'" . $date . "')";

                    mysql_query($sql_);
                    */
                        $this->debit_amount($amount, $customer_id,$remaining,$networkId,$mobileNo,$ref_no);
                            
                 $result[] = array('code' => 1, 'message' => 'Transaction Successfully');
                }
                    else 
                        $result[] = array('code' => 0, 'message' => 'Insuffient Balance');
              
            }
       $output = $this->response($result, 204);
       return $output;
    }

    public function debit_amount($amount, $customer_id,$remaining,$networkId,$mobileNo,$ref_no) {
        $date = date('Y-m-d H:i:s');
     
        $sql_ = "INSERT INTO " . DB_PREFIX . "bank_statement "
                . "values(NULL,$customer_id,'" . $date . "',$amount,0,$remaining,$networkId,'$mobileNo','$ref_no')";

        if (mysql_query($sql_)) {

            return TRUE;
        } else {
            return false;
        }
    }

}
