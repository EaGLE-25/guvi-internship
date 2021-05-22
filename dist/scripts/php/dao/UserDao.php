<?php
    namespace dao;
    require_once "../../../vendor/autoload.php";

    
    use exception\DataBaseException;
    use PDO;
    use Exception;

    
    class UserDao{
        private $host;
        private $dbname;
        private $username;
        private $password;
        private $pdo;

        function __construct(){
            $this->host = "us-cdbr-east-03.cleardb.com";
            $this->dbname = "heroku_051f65d5fdc638f";
            $this->username = "b0ce4679f65a28";
            $this->password = "8ff7a4fe";
            $dsn = "mysql:host=$this->host;dbname=$this->dbname";
            $this->pdo = new PDO($dsn,$this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        function insertUser($user){
            try{
                $sql ='INSERT INTO `users` (uuid,name,email,passwordHash,dob,mobile) VALUES(:uuid,:name, :email, :passwordHash, :dob, :mob)';
                $stmt = $this->pdo->prepare($sql);
    
                $uuid = $user->getUuid();
                $name = $user->getName();
                $email = $user->getEmail();
                $passwordHash = $user->getPasswordHash();
                $dob = $user->getDob();
                $mob = $user->getMobile();
    
                $stmt->bindParam(":uuid",$uuid);
                $stmt->bindParam(":name", $name);
                $stmt->bindParam(":email",$email);
                $stmt->bindParam(":passwordHash",$passwordHash);
                $stmt->bindParam(":dob",$dob);
                $stmt->bindParam(":mob",$mob);
    
                $stmt->execute();
            }
            catch(Exception $e){
                throw new DatabaseException($e->getMessage(),500);
            }
        }

        function getUserByEmail($email){
            try{
                $sql = 'SELECT * FROM `users` WHERE email=:email';
                $stmt = $this->pdo->prepare($sql);
    
                $stmt->bindParam(":email",$email);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
                return $user;
            }
            catch(Exception $e){
                throw new DatabaseException($e->getMessage(),500);
            }
        }

        function getProfileByEmail($email){
            try{
                $sql = 'SELECT uuid,name,email,dob,mobile FROM `users` WHERE email=:email';
                $stmt = $this->pdo->prepare($sql);
    
                $stmt->bindParam(":email",$email);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
                return $user;
            }
            catch(Exception $e){
                throw new DatabaseException($e->getMessage(),500);
            }
        }
    }
?>