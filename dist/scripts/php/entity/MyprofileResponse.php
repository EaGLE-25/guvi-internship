<?php
namespace entity;
require_once "../../../vendor/autoload.php";

class MyProfileResponse extends Response{
    var $userProfile;

    function __construct($code,$userProfile,$message=""){
        $this->code = $code;
        $this->message = $message;
        $this->userProfile = $userProfile;
    }

    function responseAsJson(){
        $resArr = array("code"=>$this->code,"message"=>$this->message,
        "userProfile"=>$this->userProfile);
        return json_encode($resArr);
    }
}
?>