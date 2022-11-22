<?php
    class Member{
        //connection property
        private $conn;
        private $tableName="church_member";


        //member properties
        public $member_id;
        public $first_name;
        public $middle_name;
        public $last_name;
        public $username;
        public $email_address;
        public $phone_number;
        public $home_address;
        public $member_password;

        //constructor with DB connection
        public function __construct($db){
            $this->conn=$db;
            
        }

        //register a new member
        public function addMember(){
            
            if($this->isUserNameChosen($this->username)){
                return json_encode(array("message"=>"Username already Chosen"));
            }else{
                $add_member_query="INSERT INTO $this->tableName(first_name, middle_name, last_name, username, email_address, home_address, phone_number, member_password) VALUES 
                (
                    '".$this->first_name."',
                    '".$this->middle_name."',
                    '".$this->last_name."', 
                    '".$this->username."', 
                    '".$this->email_address."', 
                    '".$this->home_address."',
                    '".$this->phone_number."',
                    '".$this-> member_password."'
                )";
                if($add_member_result=$this->conn->query($add_member_query)){
                    return true;
                }else{
                    printf ($this->conn->error);
                    return false;
                }
            }
        }

        //veryfy a member
        public function verifyMember(){
            
            if(!$this->isUserNameChosen($this->username)){
                return json_encode(array("status"=>"success","message"=>"User not Found"));
            }else{
                
                $select_user_details_query="SELECT first_name, middle_name, last_name, email_address, phone_number, username, member_password FROM $this->tableName WHERE username= '".$this->username."'";

                //check if the database query executed successfully
                if($select_user_details_result=$this->conn->query($select_user_details_query)){
                     //
                        $select_user_details_row=$select_user_details_result->fetch_assoc();

                        extract($select_user_details_row);

                        if(password_verify($this->member_password,$member_password)){//verify the password
                            return json_encode(array(
                                "first_name"=>$first_name,
                                "middle_name"=>$middle_name,
                                "last_name"=>$last_name,
                                "username"=>$this->username,
                                "phone_number"=>$phone_number,
                                "email_address"=>$email_address
                            ));
                        }else{
                            return json_encode(array("status"=>"success","message"=>"Incorrect Password"));
                        }
                }else{
                    return json_encode(array("status"=>"failed","message"=>$conn->error));
                }
            }
        }

        //retrieve a single member
        public function getSingleMember(){

        }

        //retrieve all members
        public function getAllMembers(){
            $select_all_members_query="SELECT membership_id,first_name, middle_name, last_name, email_address, phone_number, username, member_password FROM $this->tableName";
            if($select_all_members_result=$this->conn->query($select_all_members_query)){
                $member_array=array();
                while($select_all_members_row=$select_all_members_result->fetch_assoc()){
                    array_push($member_array,$select_all_members_row);
                }
                return json_encode($member_array);
            }else{
                return json_encode(array("status"=>"fail","message"=>$this->conn->error));
            }
        }

        //update member detail
        public function updateMemberDetails(){

        }

        //delete a member
        public function deleteMember(){

        }

        //verify that username is not chosen
        public function isUserNameChosen($username){
            $select_username_query="SELECT * FROM $this->tableName WHERE username= '".$username."'";
            if($select_username_result=$this->conn->query($select_username_query))
            if($select_username_result->num_rows>0){
                return true;
            }
            else{
                return false;
            }
        }
    }
?>