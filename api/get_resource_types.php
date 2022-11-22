<?php
require_once('../vendor/autoload.php');
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

//headers
header('Access-Control-Allow-Origin: *');
header('Content-type:application/json');
header('Access-Control-Allow-Methods: GET');


require_once("../core/resource_type.php");
require_once("../resources/connect.php");
require_once("../includes/response_code.php");

//create a new Member object
$resourceType=new ResourceType($conn);
$member=new Member($conn);

$headers=getallheaders();

// echo $resourceType->getAllResourceTypes();

try{   
        
    $secret_key="dic125";
    $jwt= $headers['Dic-Token'];

    $decoded_data= JWT::decode($jwt,new Key($secret_key,"HS512"));

    $member->username=$decoded_data->data->username;

    if($member->isUserNameChosen($member->username)){
       echo $resourceType->getAllResourceTypes();
    } else{
        setResponseCode(404);
        return json_encode(array(
            "code" => 404,
            "message" => "User Not found, Kindly re-login"
        ));
    }
    

}catch(Exception $ex){
    setResponseCode(500);
    echo json_encode(array(
        "code" => 500,
        "message" => $ex->getMessage()
    ));
}

?>