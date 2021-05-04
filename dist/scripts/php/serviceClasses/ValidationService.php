<?php
  class ValidationService{
    private $testing;

    function validateEmail($email){   
      return filter_var($email,FILTER_VALIDATE_EMAIL);
    }

    function validateName($name){
      return (preg_match('/^[a-zA-Z\s]*$/', $name) == 1)?TRUE:FALSE;
    }
  }
?>
