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
            $response_arr = array("code"=>$this->code,"message"=>$this->message);
            return json_encode($response_arr);
        }
    }
?>