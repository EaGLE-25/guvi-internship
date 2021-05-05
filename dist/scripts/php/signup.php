<?php
   require "entity/User.php";
   require "serviceClasses/UserService.php";

    if(isset($_POST['name'])){
        $newUser = new User();
        $userService = new UserService();

        $name = $_POST['name'];
        $email = $_POST['email'];
        $passwordHash = password_hash($_POST['password'],PASSWORD_DEFAULT);
        $dob = $_POST['dob'];
        $mobile = $_POST['mob'];
        
        try{
            $newUser->setName($name);
            $newUser->setEmail($email);
            $newUser->setPasswordHash($passwordHash);
            $newUser->setDob($dob);
            $newUser->setMobile($mobile);

            $userService->persistUser($newUser);
        }
        catch(Exception $e) {
            http_response_code(400);
            echo $e->getMessage();
        }
    }
?>