<?php
  require_once "./vendor/autoload.php";
  namespace service;
  
  use dao\UserDao;
  
  
  class ValidationService{
    function validateEmail($email){   
      return filter_var($email,FILTER_VALIDATE_EMAIL);
    }

    function validateName($name){
      return (preg_match('/^[a-zA-Z\s]*$/', $name) == 1)?TRUE:FALSE;
    }

    function validateMobile($mobile){
      return (preg_match('/^\d*$/', $mobile) == 1)?TRUE:FALSE;
    }

    function emailTaken($email){
      $userDao = new UserDao();
      $user = $userDao->getUserByEmail($email);
      
      if(!$user){
        return FALSE;
      }else{
        return TRUE;
      }
    }
  }
?>
