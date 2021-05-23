<?php
namespace service;
  
  
require_once "../../../vendor/autoload.php";
use service\ValidationService;
use dao\UserDao;

class UserUpdateValidationService extends ValidationService{
    function emailTaken($email){
        $headers = getallheaders();
        $loggedEmail = $headers['X-Email'];

        $userDao = new UserDao();
        $user = $userDao->getUserByEmail($email);
            
        if($user && $loggedEmail !== $user['email']){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}
?>