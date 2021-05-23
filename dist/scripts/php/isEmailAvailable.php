<?php
    use service\ValidationService;
    require_once "../../../vendor/autoload.php";

    $email = $_GET['email'];
    $for = $_GET['for'];
    $validationService;

    if($for == "signup"){
        $validationService = new ValidationService();
    }else if($for == "update"){
        $validationService = new service\UserUpdateValidationService();
    }

    $validationService = new ValidationService();
    $emailTaken = $validationService->emailTaken($email);
    if($emailTaken == true){
        echo json_encode(FALSE);
    }else{
        echo json_encode(TRUE);
    }
?>