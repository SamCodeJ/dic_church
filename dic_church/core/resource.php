<?php
    require_once("member.php");
    class Resource{
        //connection property
        private $conn;
        private $tableName="church_resource";


        //Resource properties
        public $resource_id;
        public $resource_title;
        public $resource_url;
        public $resource_content;
        public $resource_type_id;
        public $member_id;

        //constructor with DB connection
        public function __construct($db){
            $this->conn=$db;  
        }

        //register a new resource
        public function addResource(){  
            $new_resource_query="INSERT INTO $this->tableName(resource_title, resource_url, resource_content, resource_type_id, originator_member_id) VALUES (
            '".$this->resource_title."', 
            '".$this->resource_url."',
            '".$this->resource_content."',
            '".$this->resource_type_id."', 
            '".$this->member_id."'
            )";

            if($new_resource_result=$this->conn->query($new_resource_query)){
                return json_encode(array(
                    "status" => 1,
                    "message" => "Resource created Successfully"
                ));
            }else{
                return json_encode(array(
                    "status" => 0,
                    "message" => $this->conn->error
                ));
            }

        }

        //retrieve all resources
        public function getAllResource(){
            $get_all_resource_query= "SELECT resource_id, resource_title, resource_url, resource_content,type_name, CONCAT(first_name, ' ', middle_name,' ', last_name) as Member_name 
            FROM $this->tableName 
            JOIN resource_type ON 
            type_id=resource_type_id
            JOIN church_member
            ON membership_id= originator_member_id";

            if($get_all_resource_result = $this->conn->query($get_all_resource_query)){
                if($get_all_resource_result->num_rows > 0){
                    $resource_array=array();
                    while($get_all_resource_row=$get_all_resource_result->fetch_assoc()){
                        array_push($resource_array,$get_all_resource_row);
                    }
                    return json_encode(array(
                        "status" => 1,
                        "message" => "Resources Retrieved Successfully",
                        "data" => $resource_array
                    ));
                    
                }else{
                    return json_encode(array(
                        "status" => 0,
                        "message" => "No Resource has been created"
                    ));
                }
                                
            }else{
                http_response_code(500);
                return json_encode(array(
                    "status" => 1,
                    "message" => $this->conn->error
                ));
            }
        }

        //update church resource
        public function updateResource(){
            $update_resource_query="UPDATE $this->tableName SET
             resource_title='".$this->resource_title."', 
             resource_url = '".$this->resource_url."', 
             resource_content = '".$this->resource_content."', 
             resource_type_id ='".$this->resource_type_id."', 
             originator_member_id='".$this->member_id."'
             WHERE resource_id= '".$this->resource_id."'";

             if($update_resource_result = $this->conn->query($update_resource_query)){
                return json_encode(array(
                    "status" => 1,
                    "message" => "Resource Updated Successfully"
                ));
             }else{
                http_response_code(500);
                return json_encode(array(
                    "status" => 1,
                    "message" => $this->conn->error
                ));
             }
       }

        //delete a resource
        public function deleteResource(){

        }
       
    }
?>