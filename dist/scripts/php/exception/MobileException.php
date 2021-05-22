<?php
namespace exception;
use Exception;
use entity;

 class MobileException extends Exception{
  public function getError() {
    $code = $this->getCode();
    $message = $this->getMessage();
    $err = new entity\ErrorResponse($code,$message);
    return $err;
  }
 }
?>