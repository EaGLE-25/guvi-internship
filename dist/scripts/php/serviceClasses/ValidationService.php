<?php
  namespace service;
  require_once "../../../vendor/autoload.php";

  use dao\UserDao;
  use exception\EmailException;
  use exception\MobileException;
  use exception\NameException;
  
  class ValidationService{
    function validateUser($user){
      // email
      if($this->validateEmail($user->getEmail()) == FALSE){
        throw new EmailException($user->getEmail()." not a valid email",400);
      }
      
      if($this->emailTaken($user->getEmail()) == TRUE){
          throw new EmailException($user->getEmail()." already taken",400);
      }
       
      //  name
      if($this->validateName($user->getName()) == FALSE){
        throw new NameException($user->getName()." not a valid name",400);
      }
      // mobile
      if($this->validateMobile($user->getMobile()) == FALSE){
        throw new MobileException($user->getMobile()." not a valid mobile number",400);
      }
    }

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
