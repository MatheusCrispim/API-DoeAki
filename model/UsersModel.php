<?php
	
	require_once (__DIR__)."/../dao/DatabaseFunctions.php";
	require_once (__DIR__)."/../middleware/Session.php";

	
	class UsersModel{
	
		
		private $db;
		private $session;
		
		//Class Construct 
		public function __construct(){
			$this->session=new Session();
			$this->db=new DatabaseFunctions();
		}
		
	
		public function login($rawData){
			$rawData=$this->validateRawData($rawData); 
			$email=isset($rawData['email']) ? $rawData['email'] : "";
			$password=isset($rawData['password']) ? $rawData['password'] : "";
			
			$result=array(
				'email'=>false,
				'password'=>false,
				'successfull'=>false,
				'session'=>null
			);
	
			$emailValidation=$this->verifyEmail($email);
			$passwordValidation=$this->verifyPassword($password);
			
			if($emailValidation){
				$result['email']=true;	
			}
			if($passwordValidation){
				$result['password']=true;	
			}

			$validation=($emailValidation and $passwordValidation);
			
			if($validation){
				$data=array("email"=>$email, "password"=>$password);
				$foundUsers=$this->db->count("*", "Users", $data, "and");
				
				if($foundUsers>0){
					$this->session->sessionStart($email);
					$result['successfull']=true;
					$result['session']=$this->session->getId();
				}
			}

			return $result;
		}


		//This function logout the user
		public function logout($rawData){
			$data=$this->validateRawData($rawData);
			$id=isset($data['session']) ? $data['session'] : "";
			
			$result['logout']=$this->session->sessionDestroy($id);
			return $result;
		}


		//This function signup the user in the system
		public function signup($rawData){
			$data=$this->validateRawData($rawData);		
			$name=isset($data['name']) ? $data['name'] : "";
			$email=isset($data['email']) ? $data['email'] : "";
			$password=isset($data['password']) ? $data['password'] : "";
			
			$result=array(
					'name'=>false,
					'email'=>false,
					'password'=>false,
					'validation'=>false,
					'successfull'=>false
				);
			
			$nameValidation=$this->verifyName($name);
			$emailValidation=$this->verifyEmail($email);
			$passwordValidation=$this->verifyPassword($password);
			
			if($nameValidation){
				$result['name']=true;	
			}
			if($emailValidation){
				$result['email']=true;	
			}
			if($passwordValidation){
				$result['password']=true;	
			}
			
			$validation=($nameValidation and $emailValidation and $passwordValidation);
			
			if($validation){
				$result['validation']=true;
				$emailBind=array('email'=>$data['email']);
				$foundUsers=$this->db->count("*", "Users", $emailBind);
				
				if($foundUsers==0){
					$this->db->insert("Users", $data);
					$result['successfull']=true;
				}
				
			}
			
			return $result;
		}
		

		//This function validates raw data sent in the request
		public function validateRawData($rawData){
			$data=array();
			if(isset($rawData)){
				foreach($rawData as $key=>$content){
					$data[strtolower($key)]=$content;
				}
			}
			return $data;
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

