<?php
require_once("includes/rest.api.php");
?>
amount Transaction:<br>
<form method="post" action="http://localhost/ebanking/easy_load.php">
   customerId <input type="text" name="customerId" />
    financial_key<input type="text" name="financial_key"  />
     network_id<input type="text" name="networkId" />
      Mobile/Invoice<input type="text" name="mobile" />
      refNo<input type="text" name="ref_no" />
    amount<input type="text" name="amount"  />
  
    <input type="submit" name="Submit" value="Submit"  />
</form>
<br>
<br>

Create Financial Key:<br>
<form method="post" action="http://localhost/ebanking/financial_key.php">
   customerId <input type="text" name="customerId" />
  
    
  
    <input type="submit" name="Submit" value="Submit"  />
</form>
<br>
<br>

<!--
Bill Submition:<br>
<form method="post" action="http://localhost/ebanking/bill_submit.php">
   customerId <input type="text" name="customerId" />
    financial_key<input type="text" name="financial_key"  />
     Select Bill
     <select name="bill_name">
          <?php
        /*   echo  $sql_ = "SELECT
                             *
                  FROM
                     bills
                 ";

        $rs = mysql_query($sql_);
        //if (mysql_num_rows($rs) > 0) {
             while ($row = mysql_fetch_array($rs)) {
                
                $bills_id=$row['bills_id'];
                $bills_name=$row['bills_name'];*/
         ?>
             <option value="<?php //echo $bills_name;?>"><?php //echo $bills_name; }?>
            
             
         </option>
         
         
     </select>
     
     
    
    amount<input type="text" name="amount"  />
  
    <input type="submit" name="Submit" value="Submit"  />
</form>
--->


View Transaction History<br>
<form method="post" action="http://localhost/ebanking/balance_sheet.php">
   customerId <input type="text" name="customerId" />
    start Date<input type="text" name="sdate"  />
     End Date<input type="text" name="edate" />
     View All<input type="checkbox" value="1" name="all">
      
  
    <input type="submit" name="Submit" value="Submit"  />
</form>
<!--
View Mobile Load History<br>
<form method="post" action="http://localhost/ebanking/mobile_load_history.php">
   customerId <input type="text" name="loginid" />
    start Date<input type="text" name="sdate"  />
     End Date<input type="text" name="edate" />
     Mobile No<input type="text" name="mobile" />
     
     View All<input type="checkbox" value="1" name="all">
      
  
    <input type="submit" name="Submit" value="Submit"  />
</form>

<br>
<br>
--->



<?php

echo $date = date('m/d/Y h:i:s a', time());
echo '<br>';

 $rand=rand(9999, 10999);
 echo $rand;
?>