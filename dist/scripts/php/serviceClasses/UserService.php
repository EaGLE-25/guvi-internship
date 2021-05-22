<?php
  namespace service;
  
  
  require_once "../../../vendor/autoload.php";


  use dao\UserDao;
  use Exception;
  use exception\UnauthorizedException;
  use Firebase\JWT\JWT;
  use DateTimeImmutable;
  use Dotenv\Dotenv;
  use Firebase\JWT\ExpiredException;

  // $dotenv = Dotenv::createImmutable(__DIR__.'/../../../../');
  // $dotenv->load();

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

        $accessToken = $this->getJWT($email);
        $authorizedResponseAssoc = array("username"=>$user['email'],"accessToken"=>$accessToken);

        return $authorizedResponseAssoc;
      }catch(Exception $e){
        throw $e;
      }
    }

    function isAuthorized($jwt,$username){
      $now = new DateTimeImmutable();
      try{
        $token = JWT::decode($jwt, $_ENV['JWT_SECRET'], ['HS512']);
        var_dump($token);
      }
      catch(ExpiredException $e){
        throw new UnauthorizedException("Your session has expired, please login to continue",401);
      }
      catch(Exception $e){
        throw new UnauthorizedException($e->getMessage(),401);
      }
      if($token->nbf > $now->getTimestamp()){
        echo("nbf");
      }
      if($token->exp < $now->getTimestamp()){
        echo("exp");
      }
      if($token->username !== $username){
        echo("username");
      }
      if ($token->nbf > $now->getTimestamp() || $token->exp < $now->getTimestamp() || $token->username !== $username){
          throw new UnauthorizedException("Please login",401);
      }
    }

    private function authenticateUser($email,$password){
      $user = $this->userDao->getUserByEmail($email);
      $passwordHash = $user['passwordHash'];
      $passwordMatch = password_verify($password,$passwordHash);

      if(!$user || !$passwordMatch){
        throw new UnauthorizedException("Wrong email or password",401);
      }
      return $user;
    }

    private function getJWT($email){
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
        $_ENV['JWT_SECRET'],
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