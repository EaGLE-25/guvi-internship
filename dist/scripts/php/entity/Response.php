<?php
namespace entity;

    abstract class Response{
        var $code;
        var $message;

        abstract function responseAsJson();
    }
?>