<?php
  require "dao/UserDao.php";
  class UserService{
    private $userDao;
    function __construct() {
      $this->userDao = new UserDao("us-cdbr-east-03.cleardb.com","heroku_051f65d5fdc638f","b0ce4679f65a28","8ff7a4fe");
    }  
    function persistUser($user){
      $this->userDao->insertUser($user);
    }
  }
?>