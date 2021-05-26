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
                // prepare sql query with named parameters
                $stmt = $this->pdo->prepare($sql);
    
                $uuid = $user->getUuid();
                $name = $user->getName();
                $email = $user->getEmail();
                $passwordHash = $user->getPasswordHash();
                $dob = $user->getDob();
                $mob = $user->getMobile();
                
                // bind named parameters
                $stmt->bindParam(":uuid",$uuid);
                $stmt->bindParam(":name", $name);
                $stmt->bindParam(":email",$email);
                $stmt->bindParam(":passwordHash",$passwordHash);
                $stmt->bindParam(":dob",$dob);
                $stmt->bindParam(":mob",$mob);
                
                // execute the statement, throws exception
                $stmt->execute();
            }
            catch(Exception $e){
                throw new DatabaseException($e->getMessage(),500);
            }
        }

        function updateUser($user){
            try{
                $sql ="UPDATE users SET name=:name,email=:email,dob=:dob,mobile=:mob WHERE uuid=:uuid";
                // prepare sql query with named parameters
                $stmt = $this->pdo->prepare($sql);
                
                $uuid = $user->getUuid();
                $name = $user->getName();
                $email = $user->getEmail();
                $dob = $user->getDob();
                $mob = $user->getMobile();


                // bind named parameters
                $stmt->bindParam(":name", $name);
                $stmt->bindParam(":email",$email);
                $stmt->bindParam(":dob",$dob);
                $stmt->bindParam(":mob",$mob);
                $stmt->bindParam(":uuid",$uuid);

                // execute the statement, throws exception
                $stmt->execute();
            }
            catch(Exception $e){
                throw new DatabaseException($e->getMessage(),500);
            }
        }

        function getUserByEmail($email){
            try{
                $sql = 'SELECT * FROM `users` WHERE email=:email';
                // prepare sql query with named parameters
                $stmt = $this->pdo->prepare($sql);
                
                // bind named parameters
                $stmt->bindParam(":email",$email);
                // execute the statement, throws exception
                $stmt->execute();
                // if successful,fetch row as assosciative array
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
                return $user;
            }
            catch(Exception $e){
                throw new DatabaseException($e->getMessage(),500);
            }
        }
        function getUserByUuid($uuid){
            try{
                $sql = 'SELECT * FROM `users` WHERE uuid=:uuid';
                $stmt = $this->pdo->prepare($sql);
    
                $stmt->bindParam(":uuid",$uuid);
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

        function getProfileByUuid($uuid){
            try{
                $sql = 'SELECT uuid,name,email,dob,mobile FROM `users` WHERE uuid=:uuid';
                $stmt = $this->pdo->prepare($sql);
    
                $stmt->bindParam(":uuid",$uuid);
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