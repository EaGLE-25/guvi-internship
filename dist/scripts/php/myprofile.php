<?php
    require_once "../../../vendor/autoload.php";
    use service\UserService;
    use exception\UnauthorizedException;
    $userService = new UserService();
    
    $headers = getallheaders();
    try{
        if(!isset($headers['Authorization'])){
            throw new UnauthorizedException("You need to be logged in",401);
        }
        var_dump($headers);
        $authHeader = $headers['Authorization'];
        $username = $headers['X-Username'];
        $accessToken = explode(" ",$authHeader)[1];

        $userService->isAuthorized($accessToken,$username);
    }
    catch(UnauthorizedException $e){
        $err = $e->getError();
        http_response_code($err['code']);
        echo json_encode($err);
    }
?>