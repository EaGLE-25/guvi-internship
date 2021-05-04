<?php
    require_once "serviceClasses/ValidationService.php";
    require_once "exception/NameException.php";
    require_once "exception/EmailException.php";

class User{
  private $name;
  private $email;
  private $passwordHash;
  private $dob;
  private $mobile;
  private $validationService;

  function __construct(){
    $this->validationService = new ValidationService();
  }

  public function getName(){
    return $this->name;
  }

  public function setName($name){
    if($this->validationService->validateName($name) == FALSE){
      throw new NameException($name);
    }
    $this->name = $name;
  }

  public function getEmail(){
    return $this->email;
  }

  public function setEmail($email){
    if($this->validationService->validateEmail($email) == FALSE){
      throw new EmailException($email);
    }
    $this->email = $email;
  }

  public function getPasswordHash(){
    return $this->passwordHash;
  }
  public function setPasswordHash($passwordHash){
    $this->passwordHash = $passwordHash;
  }

  public function getDob(){
    return $this->dob;
  }

  public function setDob($dob){
    $this->dob = $dob;
  }

  public function getMobile(){
    return $this->mobile;
  }
  public function setMobile($mobile){
    $this->mobile = $mobile;
  }
}
?>