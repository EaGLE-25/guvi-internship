<?php
    namespace exception;
    use Exception;
    use entity;

    require_once "../../../vendor/autoload.php";
    class DatabaseException extends Exception{
        public function getError() {
            $code = $this->getCode();
            $message = $this->getMessage();
            $err = new entity\ErrorResponse($code,$message);
            return $err;
        }
    }
?>