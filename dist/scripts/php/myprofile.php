<?php
    require_once "../../../vendor/autoload.php";

    use service\UserService;
    use exception\UnauthorizedException;
    use entity\UserProfileResponse;
    $userService = new UserService();
    
    $headers = getallheaders();
    try{
        if(!isset($headers['Authorization'])){
            throw new UnauthorizedException("You need to be logged in",401);
        }
        $credentials = $userService->getCredentials($headers);

        $accessToken = $credentials[0];
        $uuid = $credentials[1];

        $userService->isAuthorized($accessToken,$uuid);

        $userProfile = $userService->getProfile($uuid);

        $response = new UserProfileResponse(200,$userProfile);
        
        echo $response->responseAsJson();
    }
    catch(UnauthorizedException $e){
        $err = $e->getError();
        http_response_code($err->code);
        echo $err->responseAsJson();
    }
?>