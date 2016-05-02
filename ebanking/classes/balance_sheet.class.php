<?php

require_once("includes/rest.api.php");

class Balance_sheet extends REST {

    /**
     * Method: customer_account_update
     * Return: true/false
     */
    public function balance_sheet_view() {
        if ($this->get_request_method() != "POST") {
            $result[] = array('response' => 'Invalid Request');
            return $this->response($result, 204);
        }

       $customer_id = $this->_request['customerId'];
       // $start_date = (isset($this->_request['sdate']))?$this->_request['sdate']:'0';
       // $end_date = (isset($this->_request['edate']))?$this->_request['edate']:'0';

  $start_date = (isset($this->_request['sdate']))?date('Y-m-d',  strtotime($this->_request['sdate'])):'0';
  $end_date = (isset($this->_request['edate']))?date('Y-m-d',  strtotime($this->_request['edate'])):'0';      
        
        $all = (isset($this->_request['all']))?$this->_request['all']:'0';
        
        if ($all == '1') {
            $view_all = $this->view_all_result($customer_id);
            $result[] = array('code' => 2, 'message' => 'View All', 'response' => $view_all);
        } else {
            $view_all = $this->view_all_result_date($customer_id, $start_date, $end_date);
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
                            bank_statement.* ,
                            networks.*
                  FROM
                    bank_statement
                    
                INNER JOIN
                networks
                ON
                bank_statement.network_id=networks.network_id
                  WHERE
                  bank_statement.login_id='$customer_id'";

        $rs = mysql_query($sql_);
        if (mysql_num_rows($rs) > 0) {
            $t=0;$i=1;
            while ($row = mysql_fetch_array($rs)) {
                $n=$i;
                $t=$row['debit']+$t;
                $close=$row['outstanding_balance'];
                $result[]= array(
                    'date' => $row['date'],
                    'Transaction_Type' => $row['network_name'],
                    'number' => $row['number'],
                    'reference_number' => $row['reference_number'],
                    'debit' => $row['debit'],
                    
                    'outstanding_balance' => $row['outstanding_balance']
                );$i++;
            }
              /////////return opening balance
            
        /*$result['opning_balance']=$this->opning_balance_first($customer_id);
            $result['Total Debit']=$t;
             $result['closing_balance'] =$close;
              $result['Total No of Transaction'] =$n;*/
            
        } else {
             $result[] = array('code' => 0, 'message' => 'Record not Found','response' => '');
                            $output = $this->response($result, 200);
                             return $output;
        }
        return array('transaction'=>$result,'opening_balance'=>$this->opning_balance_first($customer_id),'Total_Debit'=>$t,'closing_balance'=>$close,'Total_transaction'=>$n);
        //return $result;
    }

    public function view_all_result_date($customer_id, $start_date, $end_date) {
        
        
      
         $sql_ = "SELECT 
                    bank_statement.* ,
                            networks.*
                  FROM
                    bank_statement
                    
                INNER JOIN
                networks
                ON
                bank_statement.network_id=networks.network_id
                  WHERE
             DATE_FORMAT(bank_statement.`date`, '%Y-%m-%d') BETWEEN '$start_date' AND '$end_date' AND bank_statement.login_id='$customer_id'";
        $rs = mysql_query($sql_);
        if (mysql_num_rows($rs) > 0) {
            
            $t=0;$i=1;
            while ($row = mysql_fetch_array($rs)) {
                $n=$i;
                $t=$row['debit']+$t;
                $close=$row['outstanding_balance'];
                $result[] = array(
                    'date' => $row['date'],
                    'Transaction_Type' => $row['network_name'],
                    'number' => $row['number'],
                    'reference_number' => $row['reference_number'],
                    'debit' => $row['debit'],
                    
                    'outstanding_balance' => $row['outstanding_balance']
                );$i++;
            }
            /////////return opening balance
            
           /*$result['opning_balance']=$this->opning_balance($customer_id,$start_date);
            $result['Total Debit']=$t;
            $result['closing_balance'] =$close;
            $result['Total No of Transaction'] =$n;*/
            
        } else {
          $result[] = array('code' => 0, 'message' => 'Record not Found','response' => '');
                            $output = $this->response($result, 200);
                             return $output;
        }
         return array('transaction'=>$result,'opening_balance'=>$this->opning_balance_first($customer_id),'Total_Debit'=>$t,'closing_balance'=>$close,'Total_transaction'=>$n);
      
    }


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
        
}