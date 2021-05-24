<?php
    require_once "../../../vendor/autoload.php";

    use entity\User;
    use service\UserService;
    use service\UserUpdateValidationService;
    use exception\UnauthorizedException;

    try{
        $headers = getallheaders();
        $userService = new UserService();

        if(!isset($headers['Authorization'])){
            throw new UnauthorizedException("You need to be logged in",401);
        }

        $credentials = $userService->getCredentials($headers);
        $userService->isAuthorized($credentials[0],$credentials[1]);
     
         if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['mobile'])){
             $updatedUser = new User();
             $validationService = new UserUpdateValidationService();
             
             $uuid = $_POST['uuid'];
             $name = $_POST['name'];
             $email = $_POST['email'];
             $dob = isset($_POST['dob'])?$_POST['dob'] : NULL;
             $mobile = $_POST['mobile'];
             
             $updatedUser->setUuid($uuid);
             $updatedUser->setName($name);
             $updatedUser->setEmail($email);
             $updatedUser->setDob($dob);
             $updatedUser->setMobile($mobile);
            
             $validationService->validateUser($updatedUser);
             $userService->updateUser($updatedUser);
             $userService->saveUserAsJson($updatedUser);
                 
             $response = new entity\UpdatedUserResponse(200,"Updated successfully");  
                 
             echo $response->responseAsJson();             
         }else{
            $response = new entity\ErrorResponse(400,"Mandatory fields missing");
            http_response_code(400);
            echo $response->responseAsJson();
         }
    }
    catch(Exception $e) {
        $err = $e->getError();
        http_response_code($err->code);
        echo $err->responseAsJson();
     }
?>