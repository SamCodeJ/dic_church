<?php
require_once('../vendor/autoload.php');
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

//headers
header('Access-Control-Allow-Origin: *');
header('Content-type:application/json; charset=utf-8');
header('Access-Control-Allow-Methods: POST');
// header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods, Authorization,X-Requested-With');

require_once("../core/resource_type.php");
require_once("../resources/connect.php");

//create a new ResourceType object
$resouceType=new ResourceType($conn);
$member=new Member($conn);

$headers=getallheaders();

//get the request
$data=json_decode(file_get_contents("php://input"));

//mapping the request data to the object data
if(!empty($data->type_name) && !empty($data->type_description)){

    try{   
        
        $secret_key="dic125";
        $jwt= $headers['Authorization'];

        $decoded_data= JWT::decode($jwt,new Key($secret_key,"HS512"));

        $resouceType->username=$decoded_data->data->username;
        $resouceType->type_name=$data->type_name;
        $resouceType->type_description=$data->type_description;

        if($member->isUserNameChosen($resouceType->username)){
            echo $resouceType->addResourceType();
        } else{
            return json_encode(array(
                "status" => 0,
                "message" => "User Not found, Kindly re-login"
            ));
        }
        

    }catch(Exception $ex){
        http_response_code(500);
        echo json_encode(array(
            "status" => 0,
            "message" => $ex->getMessage()
        ));
    }
}else{
    http_response_code(404); //not found
    echo json_encode(array(
        "status" => 0,
        "message" => "All values needed"
    ));
}



?>