<?php
namespace service;
  
  
require_once "../../../vendor/autoload.php";
use service\ValidationService;
use dao\UserDao;

class UserUpdateValidationService extends ValidationService{
    function emailTaken($email){
        $headers = getallheaders();
        // if user logged in access X-Uuid to determine specific user
        $loggedUuid = $headers['X-Uuid'];

        $userDao = new UserDao();
        // check if any user exists for the asking email id
        $saidToBeUser = $userDao->getUserByEmail($email);
        // take logged in user email
        $loggedInUser = $userDao->getUserByUuid($loggedUuid);

        // if there is a user with asking email and its not logged in user
        if($saidToBeUser && $loggedInUser['email'] !== $saidToBeUser['email']){
            // email taken
            return TRUE;
        }else{
            // email not taken
            return FALSE;
        }
    }
}
?>