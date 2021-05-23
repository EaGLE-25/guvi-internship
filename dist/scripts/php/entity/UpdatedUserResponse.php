<?php
    namespace entity;
    require_once "../../../vendor/autoload.php";

    class UpdatedUserResponse extends Response{
        function __construct($code,$message=""){
            $this->code = $code;
            $this->message = $message;
        }

        function responseAsJson(){
            return json_encode(array("code"=>$this->code,"message"=>$this->message));
        }
    }
?>