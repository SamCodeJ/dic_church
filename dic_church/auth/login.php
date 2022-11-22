<?php
ini_set("display_errors",1);
require_once('../vendor/autoload.php');
use \Firebase\JWT\JWT;

//headers
header('Access-Control-Allow-Origin: *');
header('Content-type:application/json');
header('Access-Control-Allow-Methods: POST');
// header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods, Authorization,X-Requested-With');

require_once("../core/member.php");
require_once("../resources/connect.php");

//create a new Member object
$member=new Member($conn);

//get the request
$data=json_decode(file_get_contents("php://input"));

//mapping the request data to the object data
$member->username=$data->username;
$member->member_password=$data->member_password;

//initializing variables
$iss="sam";
$iat =time();
$nbf=$iat+10;
$exp= $iat+1800;
$aud= "my_users";
$user_data=json_decode($member->verifyMember());

$secret_key="dic125";
//initialize payload_info
$payload_info=array(
    "iss" => $iss,
    "iat" => $iat,
    "nbf" => $nbf,
    "exp" => $exp,
    "aud" => $aud,
    "data" => $user_data
);

//generate AWT token
$jwt = JWT::encode($payload_info,$secret_key,"HS512");

echo json_encode(array(
    "status"=> "1",
    "token" => $jwt,
    "message" => "Logged in Successfully"
));
?>