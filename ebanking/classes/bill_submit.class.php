<?php

require_once("includes/rest.api.php");

class Bill_submit extends REST {

    /**
     * Method: customer_account_update
     * Return: true/false
     */
    public function bill_transaction() {
        if ($this->get_request_method() != "POST") {
            $result[] = array('response' => 'Invalid Request');
            return $this->response($result, 204);
        }


        $customer_id= $this->_request['customerId'];
         $financial_key= $this->_request['financial_key'];
        $bill_name= $this->_request['bill_name'];
           //$mobile= $this->_request['mobile'];
            $amount= $this->_request['amount'];
        
      /*$mobileNo=  strlen($mobile);
        if($mobileNo>11){
            $result[] = array('code' => 0, 'message' => 'Invalid Mobile Number');
                $output = $this->response($result, 200);
                return $output;
        }
        
       */

       
        $date = date('Y-m-d H:i:s');
        // $rand=rand(10000, 99999);

        if (isset($customer_id) && $customer_id > 0) {

            //chek customer

            $sql_ = "SELECT
                             *
                  FROM
                    " . DB_PREFIX . " financial_key
                  WHERE
                     login_id ='$customer_id'  AND  random_number='$financial_key'";
            $rs = mysql_query($sql_);
            if (mysql_num_rows($rs) > 0) {
                //Chek amount

                $resp=$this->chek_amount($amount, $customer_id);
                return $resp; 
               
            } else {
                $result[] = array('code' => 0, 'message' => 'Not Found Such Financial Key OR User');
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
         $bill_name = $this->_request['bill_name'];
        // $mobileNo = $this->_request['mobile'];
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
               $success= mysql_query($sql_);
               if($success){
                
                    ///// Insert Transaction
                  $sql_ = "INSERT INTO " . DB_PREFIX . "load_draw_inbox "
                         . "values(NULL,$customer_id,'0','$bill_name',$amount,'" . $date . "')";

                    $good=mysql_query($sql_);
                        if($good){
                        $this->debit_amount($amount, $customer_id,$remaining);
                        
                        $result[] = array('code' => 1, 'message' => 'Transaction Successfully');
                        
                                  }
                                            else {
                                    $result[] = array('code' => 0, 'message' => 'Database Error');
                                                  }
               }
               else {
                    $result[] = array('code' => 0, 'message' => 'Database Error');
               }
                 
                 
                }
                    else {
                        $result[] = array('code' => 0, 'message' => 'Insuffient Balance');
                    }
            }
       $output = $this->response($result, 204);
       return $output;
    }

    public function debit_amount($amount, $customer_id,$remaining) {
        $date = date('Y-m-d H:i:s');
        $sql_ = "INSERT INTO " . DB_PREFIX . "bank_statement "
                . "values(NULL,$customer_id,'" . $date . "',$amount,0,$remaining)";

        if (mysql_query($sql_)) {

            return TRUE;
        } else {
            return false;
        }
    }

}
