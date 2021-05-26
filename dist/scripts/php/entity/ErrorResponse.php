<?php
    namespace entity;
    require_once "../../../vendor/autoload.php";

    class ErrorResponse extends Response{
        function __construct($code,$message=""){
            $this->code = $code;
            $this->message = $message;
        }

        function responseAsJson(){
            $response_arr = array("code"=>$this->code,"message"=>$this->message);
            return json_encode($response_arr);
        }
    }
?>