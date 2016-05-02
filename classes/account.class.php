<?php

require_once("includes/rest.api.php");

class Account extends REST {

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
     * Method: driver_login
     * Return: true/false
     */
    public function customer_account() {
       /* if ($this->get_request_method() != "POST") {
            $result[] = array('response' => 'Invalid Request');
            return $this->response($result, 204);
        }*/
        $sql_ = 'SELECT
                    customer_login.*,
                    current_account.*,
                    bank.*,
                    countries.*,
                    currency.*,
                    account_type.account_type_id
                  
                  FROM
                     ' . DB_PREFIX . 'customer_login
                     INNER JOIN
                     ' . DB_PREFIX . 'current_account
                       
                      ON
                    customer_login.login_id = current_account.login_id    
                    
                    INNER JOIN
                     ' . DB_PREFIX . 'account_type
                      ON
                    current_account.account_type_id = account_type.account_type_id
                    
                    INNER JOIN
                     ' . DB_PREFIX . 'bank
                      ON
                    bank.bank_id = current_account.bank_id
                    
                    INNER JOIN
                     ' . DB_PREFIX . 'countries
                      ON
                    countries.country_id = current_account.country_id
                    
                     INNER JOIN
                     ' . DB_PREFIX . 'currency
                      ON
                    currency.currency_id = current_account.currency_id
                    
                     WHERE
                    customer_login.login_id = "' . mysql_real_escape_string($this->_request['customerId']) . '"';
                        
        
         $rs = mysql_query($sql_);
         
        
         if (mysql_num_rows($rs)>0){
             $row = mysql_fetch_array($rs);           
             $is_blocked = $row['account_status'];
             $login_id = $row['login_id'];
             $userName=$row['username'];
              $Name=$row['name'];
             $accountStatus=$row['account_status'];
             $current_balance=$row['current_balance'];
             $account_no=$row['account_no'];
             $bank_name=$row['bank_name'];
             $branch_code=$row['branch_code'];
             $country_name=$row['country_name'];
              $currency_name=$row['currency_name'];
             
            
                 $driverSettings = array('UserName'=>$userName,'customerName'=>$Name,'accountStatus'=>$accountStatus,'account_no'=>$account_no,
                     'current_balance'=>$current_balance,'bank_name'=>$bank_name,'branch_code'=>$branch_code,'country_name'=>$country_name,
                     'currency_name'=>$currency_name);
                 $result[] = array('code' => 1, 'message' => 'Success','response'=>$driverSettings);
             
         } 
         else {            
             $result[] = array('code' => 0, 'message' => 'Invalid username or password');
         }
       
         
        $output = $this->response($result, 200);
        return $output;
    }
    
  

}
