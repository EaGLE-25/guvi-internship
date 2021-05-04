<?php
 class EmailException extends Exception{
  public function errorMessage() {
    $errorMsg = $this->getMessage().' is not a valid email address';
    return $errorMsg;
  }
 }
?>
