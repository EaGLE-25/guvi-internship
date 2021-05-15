<?php
  require_once "dao/UserDao.php";

  class UserService{
    private $userDao;

    function __construct() {
      $this->userDao = new UserDao();
    }  

    function signupUser($user){
      try{
        $this->userDao->insertUser($user);
      }
      catch(Exception $e){
        throw $e;
      }
    }
    function saveUserAsJson($user){
      $userAssoc = array(
        "uuid"=>$user->getUuid(),
        "name"=>$user->getName(),
        "email"=>$user->getEmail(),
        "passwordHash"=>$user->getPasswordHash(),
        "dob"=>$user->getDob(),
        "mobile"=>$user->getMobile()
      );

      $path = "../../storage/users.json";
      $fileContents = file_get_contents($path);
      $usersArr = json_decode($fileContents);
      
      array_push($usersArr,$userAssoc);
      $jsonUsersArr = json_encode($usersArr);

      file_put_contents($path,$jsonUsersArr);
    }
  }
?>