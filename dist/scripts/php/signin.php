<?php
    $headers = getallheaders();
    $authHeader = $headers['Authorization'];
    $base64EmailPassword = explode(" ",$authHeader)[1];
    
    $decodedEmailPassword = base64_decode($base64EmailPassword);

    $emailPasswordArr = explode(":",$decodedEmailPassword);

    $email = $emailPasswordArr[0];
    $password = $emailPasswordArr[1];
?>