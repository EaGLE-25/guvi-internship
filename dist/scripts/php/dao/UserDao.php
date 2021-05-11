<?php
    class UserDao{
        private $host;
        private $dbname;
        private $username;
        private $password;
        private $conn;
        private $pdo;
        
        function __construct($host,$dbname,$username,$password){
            $this->host = $host;
            $this->dbname = $dbname;
            $this->username = $username;
            $this->password = $password;
            $dsn = "mysql:host=$host;dbname=$dbname";
            $this->pdo = new PDO($dsn,$username,$password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        function insertUser($user){
            $sql ='INSERT INTO `users` (name,email,passwordHash,dob,mobile) VALUES(:name, :email, :passwordHash, :dob, :mob)';
            $stmt = $this->pdo->prepare($sql);

            $name = $user->getName();
            $email = $user->getEmail();
            $passwordHash = $user->getPasswordHash();
            $dob = $user->getDob();
            $mob = $user->getMobile();

            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":email",$email);
            $stmt->bindParam(":passwordHash",$passwordHash);
            $stmt->bindParam(":dob",$dob);
            $stmt->bindParam(":mob",$mob);

            $stmt->execute();
        }
    }
?>