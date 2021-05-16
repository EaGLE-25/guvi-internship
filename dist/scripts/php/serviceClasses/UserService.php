<?php
  namespace service;
  
  
  require_once "../../../vendor/autoload.php";


  use dao\UserDao;
  use Exception;
  use exception\UnauthorizedException;
  use Firebase\JWT\JWT;
  use DateTimeImmutable;

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

    function loginUser($email,$password){
      try{
        $user = $this->authenticateUser($email,$password);

        $email = $user['email'];
        $passwordHash = $user['passwordHash'];

        $accessToken = $this->getJWT($email,$passwordHash);
        $authorizedResponseAssoc = array("username"=>$user['email'],"accessToken"=>$accessToken);

        return $authorizedResponseAssoc;
      }catch(Exception $e){
        throw $e;
      }
    }

    private function authenticateUser($email,$password){
      $user = $this->userDao->getUserByEmail($email);
      $passwordHash = $user['passwordHash'];
      $passwordMatch = password_verify($password,$passwordHash);

      if(!$user || !$passwordMatch){
        throw new UnauthorizedException("Email or password does not match",401);
      }
      return $user;
    }

    private function getJWT($email,$secret){
      $issuedAt = new DateTimeImmutable();
        $expire = $issuedAt->modify('+6 minutes')->getTimestamp();

        $payload = [
          'iat'  => $issuedAt->getTimestamp(),       
          'nbf'  => $issuedAt->getTimestamp(),         
          'exp'  => $expire,                          
          'username' => $email,                     
      ];

      
      $accessToken = JWT::encode(
        $payload,
        $secret,
        'HS512'
      );
      return $accessToken;
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