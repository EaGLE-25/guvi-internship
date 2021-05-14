<?php
  require_once "dao/UserDao.php";

  class UserService{
    private $userDao;

    function __construct() {
      $this->userDao = new UserDao();
    }  

    function persistUser($user){
      try{
        $this->userDao->insertUser($user);
      }
      catch(Exception $e){
        throw $e;
      }
    }
  }
?>