<?php
    namespace entity;
    require_once "../../../vendor/autoload.php";

    class AuthenticatedResponse extends Response{
        var $accessToken;
        var $email;

        function __construct($code,$accessToken,$email,$message=""){
            $this->code = $code;
            $this->message = $message;
            $this->accessToken = $accessToken;
            $this->email = $email;
        }

        function responseAsJson(){
            return json_encode(array("code"=>$this->code,"message"=>$this->message,"accessToken"=>$this->accessToken,"email"=>$this->email));
        }
    }
?>