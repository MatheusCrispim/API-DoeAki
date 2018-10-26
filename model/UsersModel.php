<?php
	
	require_once (__DIR__)."/../dao/DatabaseFunctions.php";

	
	class UsersModel{
	
		
		private $db;
		
		//Class Construct 
		public function __construct(){
			$this->db=new DatabaseFunctions();
		}
		
		public function login($data){
			
		}

	
		public function signup($rawData){
			
			$data=array();
			if(isset($rawData)){
				foreach($rawData as $key=>$content){
					$data[strtolower($key)]=$content;
				}
			}
			
			$name=isset($data['name']) ? $data['name'] : "";
			$email=isset($data['email']) ? $data['email'] : "";
			$password=isset($data['password']) ? $data['password'] : "";
			
			$result=array(
					'name'=>"false",
					'email'=>"false",
					'password'=>"false",
					'validation'=>"false",
					'successfull'=>"false"
				);
			
			$nameValidation=$this->verifyName($name);
			$emailValidation=$this->verifyEmail($email);
			$passwordValidation=$this->verifyPassword($password);
			
			if($nameValidation==true){
				$result['name']="true";	
			}
			if($emailValidation==true){
				$result['email']="true";	
			}
			if($passwordValidation==true){
				$result['password']="true";	
			}
			
			$validation=($nameValidation and $emailValidation and $passwordValidation);
			
			if($validation==true){
				$result['validation']="true";
				$emailBind=array('email'=>$data['email']);
				$foundUsers=$this->db->count("*", "Users", $emailBind);
				
				if($foundUsers==0){
					$this->db->insert("Users", $data);
					$result['successfull']="true";
				}
				
			}
			
			return $result;
		}
		
		
		//Name validation
		public function verifyName($name){
			$result=false;
			if(strlen(trim($name))>0){
				$result=true;
			}
			return $result;
		}	
		
			
		//Email validation	
		public function verifyEmail($email){
			$result=false;
			if(filter_var($email, FILTER_VALIDATE_EMAIL)){
				$result=true;
			}
			return $result;
		}	
		
		
		//Password validation 
		public function verifyPassword($password){
			$result=false;
			if(strlen(trim($password))>3){
				$result=true;
			}
			return $result;
		}
		
	}
?>

