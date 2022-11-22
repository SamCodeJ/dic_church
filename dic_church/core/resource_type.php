<?php
    require_once("member.php");
    class ResourceType{
        //connection property
        private $conn;
        private $tableName="resource_type";


        //Resource Type properties
        public $type_id;
        public $type_name;
        public $type_description;
        public $member_username;

        //constructor with DB connection
        public function __construct($db){
            $this->conn=$db;  
        }

        //register a new type
        public function addResourceType(){  

            if($this->isResourceTypeExist($this->type_name)){
                return json_encode(array(
                    "status"=>0,
                    "message" => "Resource type already exists"
                ));
            }else{
                $add_type_query="INSERT INTO $this->tableName (type_name, type_description) VALUES('".$this->type_name."','".$this->type_description."')";

                if($add_type_result=$this->conn->query($add_type_query)){
                    return json_encode(array(
                        "status" => "1",
                        "messsage" => "Resource Type successfully Created"
                    ));
                }else{
                    return json_encode(array(
                        "status" => "0",
                        "message" => $this->conn->error
                    ));
                }
            }
           
        }

        //retrieve all resource types
        public function getAllResourceTypes(){
            $select_all_type_query="SELECT * FROM $this->tableName";
            if($select_all_type_result=$this->conn->query($select_all_type_query)){
                $type_array=array();
                while($select_all_type_row=$select_all_type_result->fetch_assoc()){
                    array_push($type_array,$select_all_type_row);
                }
                return json_encode($type_array);
            }else{
                return json_encode(array("status"=>"fail","message"=>$this->conn->error));
            }
        }

        //update resource type detail
        public function updateResourceType(){
            $update_resource_type_query="UPDATE $this->tableName SET type_name='".$this->type_name."', type_description= '".$this->type_description."' WHERE type_id= '".$this->type_id."'";
            if($update_resource_type_result=$this->conn->query($update_resource_type_query)){
                echo json_encode(array(
                    "status"=>0,
                    "message"=>"Resource Type Successfully Updated"
                ));
            }else{
                echo json_encode(array(
                    "status"=>0,
                    "message"=>$this->conn->error
                ));
            }
        }

        //delete a resource type
        public function deleteResourceType(){

        }

        //check if the resource type already exists
        public function isResourceTypeExist($type_name){
            $check_type_query="SELECT * from $this->tableName where type_name = '".$type_name."'";
            $check_type_result=$this->conn->query($check_type_query);
            if($check_type_result->num_rows >0){
                return true;
            }else{
                return false;
            }

        }
       
    }
?>