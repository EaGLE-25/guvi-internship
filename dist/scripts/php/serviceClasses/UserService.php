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
      $this->validationService = new ValidationService();
    }  

    function signupUser($user){
      try{
        // throws DataBaseException
        $this->userDao->insertUser($user);
      }
      catch(Exception $e){
        // re throw to control layer
        throw $e;
      }
    }

    function loginUser($email,$password){
      try{
        // throws unauthorized Exception
        $user = $this->authenticateUser($email,$password);

        $uuid = $user['uuid'];

        $accessToken = $this->getJWT($uuid);
        $authenticatedResponseAssoc = array("uuid"=>$user['uuid'],"accessToken"=>$accessToken);

        return $authenticatedResponseAssoc;
      }catch(Exception $e){
        // re throw to control layer
        throw $e;
      }
    }

    function getProfile($uuid){
      return $this->userDao->getProfileByUuid($uuid);
    }

    function isAuthorized($jwt,$uuid){
      $now = new DateTimeImmutable();
      try{
        $token = JWT::decode($jwt, $_ENV['JWT_SECRET'], ['HS512']);
      }
      catch(ExpiredException $e){
        throw new UnauthorizedException("Your session has expired, please login to continue",401);
      }
      catch(Exception $e){
        throw new UnauthorizedException("Please login",401);
      }
      if ($token->nbf > $now->getTimestamp() || $token->exp < $now->getTimestamp() || $token->uuid !== $uuid){
          throw new UnauthorizedException("Please login uuid",401);
      }
    }

    function getCredentials($headers){
      $authHeader = $headers['Authorization'];
      $uuid = $headers['X-Uuid'];
      $accessToken = explode(" ",$authHeader)[1];

      return array($accessToken,$uuid);
    }

    function updateUser($user){
      try{
        $this->userDao->updateUser($user);
      }
      catch(Exception $e){
        throw $e;
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

    private function getJWT($uuid){
      $issuedAt = new DateTimeImmutable();
        $expire = $issuedAt->modify('+6 minutes')->getTimestamp();

        $payload = [
          'iat'  => $issuedAt->getTimestamp(),       
          'nbf'  => $issuedAt->getTimestamp(),         
          'exp'  => $expire,                          
          'uuid' => $uuid,                     
      ];

      
      $accessToken = JWT::encode(
        $payload,
        $_ENV['JWT_SECRET'],
        'HS512'
      );
      return $accessToken;
    }

    function saveUserAsJson($user){
      $userUuid = $user->getUuid();
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
      $usersArr = json_decode($fileContents,true);
      
      $usersArr[$userUuid] = $userAssoc;

      $jsonUsersArr = json_encode($usersArr);

      file_put_contents($path,$jsonUsersArr);
    }
  }
?>