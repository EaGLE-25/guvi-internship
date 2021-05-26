<?php
    namespace entity;
    require_once "../../../vendor/autoload.php";

    use service\ValidationService;
    

class User{
  private $uuid;
  private $name;
  private $email;
  private $passwordHash;
  private $dob;
  private $mobile;

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
    $this->name = $name;
  }

  public function getEmail(){
    return $this->email;
  }

  public function setEmail($email){
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