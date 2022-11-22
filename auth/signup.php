<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-type:application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods, Authorization,X-Requested-With');

require_once("../core/Member.php");
require_once("../resources/connect.php");

//create a new Member object
$member=new Member($conn);

//get the request
$data=json_decode(file_get_contents("php://input"));

//mapping the request data to the object data
$member->first_name=$data->first_name;
$member->middle_name=$data->middle_name;
$member->last_name=$data->last_name;
$member->username=$data->username;
$member->email_address=$data->email_address;
$member->home_address=$data->home_address;
$member->phone_number=$data->phone_number;
$member->member_password= password_hash($data->member_password, PASSWORD_DEFAULT);

if($member->addMember()===true){
    echo json_encode(array("code"=>"201","message"=>"New user successfully Created"));
}else if($member->addMember()===false){
    echo json_encode(array("code"=>500,"message"=>"Member Not Added"));
}else{
    echo $member->addMember();
}

?>