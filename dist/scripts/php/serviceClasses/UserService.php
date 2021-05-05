<?php
  class UserService{
    function persistUser($user){
      $dsn = "mysql:host=us-cdbr-east-03.cleardb.com;dbname=heroku_051f65d5fdc638f";
      $pdo = new PDO($dsn,'b0ce4679f65a28','8ff7a4fe');
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql = 'INSERT INTO `users` (name,email,passwordHash,dob,mobile) VALUES(:name, :email, :passwordHash, :dob, :mob)';
      $stmt = $pdo->prepare($sql);

      $name = $user->getName();
      $email = $user->getEmail();
      $passwordHash = $user->getPasswordHash();
      $dob = $user->getDob();
      $mob = $user->getMobile();

      $stmt->execute([':name'=>$name,':email'=>$email,':passwordHash'=>$passwordHash,":dob"=>$dob,":mob"=>$mob]);
    }
  }
?>