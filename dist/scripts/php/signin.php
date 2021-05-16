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

        $userService->loginUser($email,$password);
    }
    catch(UnauthorizedException $e){
        $err = $e->getError();
        http_response_code($err['code']);
        echo json_encode($err);
    }
    catch(Exception $e){
        $err = array("code"=>$e->getCode(),"message"=>$e->getMessage());
        http_response_code($err['code']);
        echo json_encode($err); 
    }
?>