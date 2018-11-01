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
		
	
		//This function logs the user in 
		public function login($rawData){
			$data=$this->validateRawData($rawData); 
			$email=isset($data['email']) ? $data['email'] : "";
			$password=isset($data['password']) ? $data['password'] : "";
			
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


		//This function verify if user is logged
		public function isLogged($rawData){
			$data=$this->validateRawData($rawData);
			$id=isset($data['session']) ? $data['session'] : "";

			$result['logged']=$this->session->sessionIsValid($id);
			$this->session->sessionResume($id);

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
			$image=isset($data['image']) ? $data['image'] : "";
			
			$result=array(
					'name'=>false,
					'email'=>false,
					'password'=>false,
					'image'=>false,
					'validation'=>false,
					'successfull'=>false
				);

			$nameValidation=$this->verifyName($name);
			$emailValidation=$this->verifyEmail($email);
			$passwordValidation=$this->verifyPassword($password);
			$imageValidation=$this->checkBase64Image($image);			

			if($nameValidation){
				$result['name']=true;	
			}
			if($emailValidation){
				$result['email']=true;	
			}
			if($passwordValidation){
				$result['password']=true;	
			}
			if($imageValidation){
				$result['image']=true;
			}

			$validation=($nameValidation and $emailValidation and $passwordValidation);

			if($validation){
				$result['validation']=true;
				$emailBind=array('email'=>$data['email']);
				$foundUsers=$this->db->count("*", "Users", $emailBind);
				
				if($foundUsers==0){
					if($imageValidation){
						$imagePath="uploads/profiles/";
						$imagName=md5(uniqid()).".png";
						$this->saveImage($data['image'], $imagePath, $imagName);
						$data['image']=$imagePath.$imagName;
					}else{
						$data['image']="uploads/profiles/default/default.png";
					}

					$this->db->insert("Users", $data);
					$result['successfull']=true;
				}
				
			}
			
			return $result;
		}
		

		//This function returns the user info
		public function getUser($item, $data){
			return $this->db->select($item, "Users", $data, "or");
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


	//This Function saves the imagem on the server
	public function saveImage($image, $path, $name){
		$image=explode(',', $image)[1];
		$imageData=base64_decode($image);
		file_put_contents($path.$name, $imageData);
	}


	//This function checks if the image base64 is valid
	public function checkBase64Image($data){

		if($this->is_base64($data)){
			return false;
		}

		$data=explode(',', $data)[1];
		$data=base64_decode($data);
		$img=imagecreatefromstring($data); 

		if(!$img) { 
			return false; 
		} 
		$size = getimagesizefromstring($data); 
		if (!$size || $size[0] == 0 || $size[1] == 0 || !$size['mime']) {
			return false; 
		} 
		return true;
	} 


	//check if data is base64
	function is_base64($data){
		if (base64_decode($data, true) === false) {
			return false;
		} 
		return true;
	}
	
		
	}
?>

