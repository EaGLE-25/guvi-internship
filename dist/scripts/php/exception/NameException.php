<?php
 class NameException extends Exception{
  public function errorMessage() {
    $errorMsg = $this->getMessage().' is not a valid name';
    return $errorMsg;
  }
 }
?>