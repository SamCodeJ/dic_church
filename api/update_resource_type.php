<?php

require_once('../vendor/autoload.php');
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

//headers
header('Access-Control-Allow-Origin: *');
header('Content-type:application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods, Authorization,X-Requested-With');

require_once("../core/resource_type.php");
require_once("../resources/connect.php");
require_once("../includes/response_code.php");
require_once("../core/member.php");

//create a new ResourceType object
$resouceType=new ResourceType($conn);
$member=new Member($conn);

$headers=getallheaders();

//get the request
$data=json_decode(file_get_contents("php://input"));

//mapping the request data to the object data
if(!empty($data->type_name) && !empty($data->type_description) && !empty($data->type_id)){

    try{   
        
        $secret_key="dic125";
        $jwt= $headers['Dic-Token'];

        $decoded_data= JWT::decode($jwt,new Key($secret_key,"HS512"));

        $member->username=$decoded_data->data->username;

        if($member->isUserNameChosen($member->username)){

            $resouceType->type_id=$data->type_id;
            $resouceType->type_name=$data->type_name;
            $resouceType->type_description=$data->type_description;

            // echo $resource->updateResource();
            echo ($resouceType->updateResourceType());
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
}else{
    setResponseCode(404); //not found
    echo json_encode(array(
        "code" => 409,
        "message" => "All values needed"
    ));
}
?>