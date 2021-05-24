<?php
namespace service;
  
  
require_once "../../../vendor/autoload.php";
use service\ValidationService;
use dao\UserDao;

class UserUpdateValidationService extends ValidationService{
    function emailTaken($email){
        $headers = getallheaders();
        $loggedUuid = $headers['X-Uuid'];

        $userDao = new UserDao();
        $saidToBeUser = $userDao->getUserByEmail($email);
        $loggedInUser = $userDao->getUserByUuid($loggedUuid);

        if($saidToBeUser && $loggedInUser['email'] !== $saidToBeUser['email']){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}
?>