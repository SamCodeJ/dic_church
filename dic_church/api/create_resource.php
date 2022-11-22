<?php
require_once('../vendor/autoload.php');
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

//headers
header('Access-Control-Allow-Origin: *');
header('Content-type:application/json; charset=utf-8');
header('Access-Control-Allow-Methods: POST');
// header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods, Authorization,X-Requested-With');

require_once("../core/resource.php");
require_once("../core/member.php");
require_once("../resources/connect.php");

//create a new ResourceType object
$resource=new Resource($conn);
$member=new Member($conn);

$headers=getallheaders();

//get the request
$data=json_decode(file_get_contents("php://input"));

//mapping the request data to the object data
if(!empty($data->resource_title) && !empty($data->resource_type_id) && !empty($data->member_id)){

    try{   
        
        $secret_key="dic125";
        $jwt= $headers['Authorization'];

        $decoded_data= JWT::decode($jwt,new Key($secret_key,"HS512"));

        $member->username=$decoded_data->data->username;

        if($member->isUserNameChosen($member->username)){
            
            $resource->resource_title=$data->resource_title;
            $resource->resource_url=$data->resource_url;
            $resource->resource_content=$data->resource_content;
            $resource->resource_type_id=$data->resource_type_id;
            $resource->member_id=$data->member_id;

            echo $resource->addResource();
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