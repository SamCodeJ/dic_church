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

//create a new ResourceType object
$resouceType=new ResourceType($conn);

//get the request
$data=json_decode(file_get_contents("php://input"));

//mapping the request data to the object data
$resouceType->type_id=$data->type_id;
$resouceType->type_name=$data->type_name;
$resouceType->type_description=$data->type_description;

echo ($resouceType->updateResourceType());

// if($resouceType->updateResourceType()===true){
//     echo json_encode(array("status"=>"success","message"=>"Resource Type successfully Created"));
// }else {
//     echo json_encode(array("status"=>"fail","message"=>$resouceType->addResourceType()));
// }
?>