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
        $credentials = $userService->getCredentials($headers);

        $accessToken = $credentials[0];
        $email = $credentials[1];

        $userService->isAuthorized($accessToken,$email);

        $userProfile = $userService->getProfile($email);

        $response = new entity\MyProfileResponse(200,$userProfile);
        
        echo $response->responseAsJson();
    }
    catch(UnauthorizedException $e){
        $err = $e->getError();
        http_response_code($err->code);
        echo $err->responseAsJson();
    }
?>