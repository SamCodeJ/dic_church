<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-type:application/json');


require_once("../core/Member.php");
require_once("../resources/connect.php");

//create a new Member object
$member=new Member($conn);

echo $member->getAllMembers();

?>