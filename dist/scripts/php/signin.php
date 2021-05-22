<?php
    require_once "../../../vendor/autoload.php";
    use service\UserService;
    use exception\UnauthorizedException;
    $userService = new UserService();

    $headers = getallheaders();
    try{
        if(!isset($headers['Authorization'])){
            throw new Exception("Bad Request",400);
        }
        $authHeader = $headers['Authorization'];
        $base64EmailPassword = explode(" ",$authHeader)[1];
        
        $decodedEmailPassword = base64_decode($base64EmailPassword);

        $emailPasswordArr = explode(":",$decodedEmailPassword);

        $email = $emailPasswordArr[0];
        $password = $emailPasswordArr[1];

        $authenticatedResponseAssoc = $userService->loginUser($email,$password);
        
        $response = new entity\AuthenticatedResponse(200,$authenticatedResponseAssoc['accessToken'],$authenticatedResponseAssoc['email']);

        echo $response->responseAsJson();
    }
    catch(UnauthorizedException $e){
        $err = $e->getError();
        http_response_code($err->code);
        echo $err->responseAsJson();
    }
    catch(Exception $e){
        $err = $e->getError();
        http_response_code($err->code);
        echo $err->responseAsJson();
    }
?>