<?php

use exception\EmailException;
use service\ValidationService;
    use service\UserUpdateValidationService;
    require_once "../../../vendor/autoload.php";

    $email = $_GET['email'];
    $for = $_GET['for'];
    $validationService;

    if($for == "signup"){
        $validationService = new ValidationService();
    }else if($for == "update"){
        $validationService = new UserUpdateValidationService();
    }
    try{
        $validationService->validateEmail($email);

        $emailTaken = $validationService->emailTaken($email);
        if($emailTaken == true){
            echo json_encode(FALSE);
        }else{
            echo json_encode(TRUE);
        }
    }
    catch(EmailException $e){
        $response = new entity\ErrorResponse(400,"Invalid Email");
        echo $response->responseAsJson();
    }

?>