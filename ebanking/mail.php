<?php


$to = "engr.attari@gmail.com";
        $subject = "Financial Key";
        $message = "This financial Key will be expired after 15 minuts.";
        $from = "ebanking@mobilebanking.com";
        $headers = "From: $from";
        echo mail($to, $subject, $message);
        
        ?>