<?php
    namespace entity;
    require_once "../../../vendor/autoload.php";

    class SignupResponse extends Response{
        var $userProfile;

        function __construct($code,$message=""){
            $this->code = $code;
            $this->message = $message;
        }

        function responseAsJson(){
            return json_encode(array("code"=>$this->code,"message"=>$this->message));
        }
    }
?>