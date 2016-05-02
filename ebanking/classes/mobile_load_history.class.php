<?php

require_once("includes/rest.api.php");

class mobile_load_history extends REST {

    /**
     * Method: customer_account_update
     * Return: true/false
     */
    public function mobile_load_view() {
        if ($this->get_request_method() != "POST") {
            $result[] = array('response' => 'Invalid Request');
            return $this->response($result, 204);
        }

        $customer_id = $this->_request['loginid'];
        $start_date = $this->_request['sdate'];
        $end_date = $this->_request['edate'];
        $mobile = $this->_request['mobile'];

         $all = (isset($this->_request['all']))?$this->_request['all']:'0';

        if ($all == '1') {
            $view_all = $this->view_all_result($customer_id);
            $result[] = array('code' => 2, 'message' => 'View All', 'response' => $view_all);
        } else {
            $view_all = $this->view_all_result_date($customer_id, $start_date, $end_date,$mobile);
            $result[] = array('code' => 2, 'message' => 'View ', 'response' => $view_all);
        }

        $output = $this->response($result, 200);
        return $output;
    }

    /**
     * Method: customer_account_update
     * Return: true/false
     */
    public function view_all_result($customer_id) {

         $sql_ = "SELECT
                             *
                  FROM
                    " . DB_PREFIX . " load_draw_inbox
                  WHERE
                    login_id='$customer_id'";

        $rs = mysql_query($sql_);
        if (mysql_num_rows($rs) > 0) {
            $t=0;$i=1;
            while ($row = mysql_fetch_array($rs)) {
                $n=$i;
                $t=$row['amount']+$t;
                
                $result[] = array(
                    'date' => $row['date'],
                    'mobile' => $row['mobileNo'],
                    
                    'load' => $row['amount']
                );$i++;
            }
              /////////return opening balance
            
         //  $result['opning_balance']=$this->opning_balance_first($customer_id);
            $result['Total Load']=$t;
             //$result['closing_balance'] =$close;
              $result['Total No of Load'] =$n;
            
        } else {
            return 0;
        }
        return $result;
    }

    public function view_all_result_date($customer_id, $start_date, $end_date,$mobile) {
      
        $sql_ = "SELECT
                             *
                  FROM
                    " . DB_PREFIX . " load_draw_inbox
                  WHERE
                     date BETWEEN '$start_date' AND '$end_date' AND login_id='$customer_id' AND mobileNo='$mobile'";
        $rs = mysql_query($sql_);
        if (mysql_num_rows($rs) > 0) {
            
            $t=0;$i=1;
            while ($row = mysql_fetch_array($rs)) {
                $n=$i;
                $t=$row['amount']+$t;
             //   $close=$row['outstanding_balance'];
               $result[] = array(
                    'date' => $row['date'],
                    'mobile' => $row['mobileNo'],
                    
                    'load' => $row['amount']
                );$i++;
            }
            /////////return opening balance
            
         //  $result['opning_balance']=$this->opning_balance($customer_id,$start_date);
            $result['Total Load']=$t;
             //$result['closing_balance'] =$close;
              $result['Total No of Load'] =$n;
            
        } else {
            return 0;
        }
        return $result;
    }

/*
  public function opning_balance($customer_id, $start_date) {
      
     $sql_ = "SELECT
                             *
                  FROM
                    " . DB_PREFIX . " bank_statement
                  WHERE
                     date='$start_date' AND login_id='$customer_id' LIMIT 1";
        $rs = mysql_query($sql_);
        if (mysql_num_rows($rs) > 0) {
            
            
            while ($row = mysql_fetch_array($rs)) {
                $result=$row['outstanding_balance']+$row['debit'];
                 
            }
            return $result;
            
  } 
  else {
            return 0;
        }
       
    
        }
        
  public function opning_balance_first($customer_id) {
      
     $sql_ = "SELECT
                             *
                  FROM
                    " . DB_PREFIX . " bank_statement
                  WHERE
                     login_id='$customer_id' LIMIT 1";
        $rs = mysql_query($sql_);
        if (mysql_num_rows($rs) > 0) {
            
            
            while ($row = mysql_fetch_array($rs)) {
                $result=$row['outstanding_balance']+$row['debit'];
                 
            }
            return $result;
            
  } 
  else {
            return 0;
        }
       
    
        }      
 */       
}