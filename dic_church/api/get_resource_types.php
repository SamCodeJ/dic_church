<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-type:application/json');


require_once("../core/resource_type.php");
require_once("../resources/connect.php");

//create a new Member object
$resourceType=new ResourceType($conn);

echo $resourceType->getAllResourceTypes();

?>