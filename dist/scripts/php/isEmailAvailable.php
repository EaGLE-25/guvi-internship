<?php
    require_once "serviceClasses/ValidationService.php";

    $email = $_GET['email'];
    $validationService = new ValidationService();
    $user = $validationService->emailTaken($email);
    if(!$user){
        echo json_encode(TRUE);
    }else{
        echo json_encode(FALSE);
    }
?>