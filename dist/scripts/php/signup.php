<?php
   use Exception;
   require_once "./vendor/autoload.php";
   

    if(isset($_POST['name'])){
        $newUser = new entity\User();
        $userService = new service\UserService();

        $name = $_POST['name'];
        $email = $_POST['email'];
        $passwordHash = password_hash($_POST['password'],PASSWORD_DEFAULT);
        $dob = isset($_POST['dob'])?$_POST['dob'] : NULL;
        $mobile = $_POST['mob'];
        
        try{
            $newUser->setUuid(uniqid());
            $newUser->setName($name);
            $newUser->setEmail($email);
            $newUser->setPasswordHash($passwordHash);
            $newUser->setDob($dob);
            $newUser->setMobile($mobile);

            $userService->signupUser($newUser);
            $userService->saveUserAsJson($newUser);
            http_response_code(201);
        }
        catch(Exception $e) {
            $err = $e->getError();
            http_response_code($err['code']);
            echo json_encode($err); 
        }
    }
?>