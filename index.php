<form method="post" action="financial_key.php">
    <input type="text" name="customerId" />
    <input type="text" name="password"  />
  
    <input type="submit" name="Submit" value="Submit"  />
</form>

<?php

echo $date = date('m/d/Y h:i:s a', time());
echo '<br>';

 $rand=rand(9999, 10999);
 echo $rand;
?>