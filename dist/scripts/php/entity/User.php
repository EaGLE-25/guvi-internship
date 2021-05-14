<?php
    require_once "serviceClasses/ValidationService.php";
    require_once "exception/NameException.php";
    require_once "exception/EmailException.php";
    require_once "exception/MobileException.php";

class User{
  private $uuid;
  private $name;
  private $email;
  private $passwordHash;
  private $dob;
  private $mobile;
  private $validationService;

  function __construct(){
    $this->validationService = new ValidationService();
  }

  public function getUuid(){
    return $this->uuid;
  }

  public function setUuid($uuid){
    $this->uuid = $uuid;
  }

  public function getName(){
    return $this->name;
  }

  public function setName($name){
    if($this->validationService->validateName($name) == FALSE){
      throw new NameException($name." not a valid name",400);
    }
    $this->name = $name;
  }

  public function getEmail(){
    return $this->email;
  }

  public function setEmail($email){
    if($this->validationService->validateEmail($email) == FALSE){
      throw new EmailException($email." not a valid email",400);
    }else if($this->validationService->emailTaken($email) == TRUE){
      throw new EmailException($email." already taken",400);
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
    if($this->validationService->validateMobile($mobile) == FALSE){
      throw new MobileException($mobile." not a valid mobile number",400);
    }
    $this->mobile = $mobile;
  }
}
?>