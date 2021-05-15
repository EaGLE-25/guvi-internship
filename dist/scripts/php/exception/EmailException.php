<?php
namespace exception;
use Exception;
 class EmailException extends Exception{
  public function getError() {
    $code = $this->getCode();
    $message = $this->getMessage();
    $err_arr = array("code"=>$code,"message"=>$message);
    return $err_arr;
  }
 }
?>
