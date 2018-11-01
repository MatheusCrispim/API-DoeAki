<?php
	
	require_once (__DIR__)."/../dao/DatabaseFunctions.php";

	
	class InstitutionsModel{
	
		private $db;
		
		//Class Construct 
		public function __construct(){
			$this->db=new DatabaseFunctions();
		}
		

		//This method returns the nearby institutions
		public function getNearbyInstitutions($data){
			$cmmd="SELECT *,
			(6371 * acos(
			 cos( radians(:latitude) )
			 * cos( radians( latitude ) )
			 * cos( radians( longitude ) - radians(:longitude) )
			 + sin( radians(:latitude) )
			 * sin( radians( latitude ) ) 
			 )
			) AS distancia
			FROM `Institutions` 
			HAVING distancia < :radius
			ORDER BY distancia ASC;";
			
			return $this->db->execute($cmmd, $data)->fetchAll();			
		}

		//This method returns the institutions searched by the user, according to the $where params
		public function getInstitutions($item, $data){
			return $this->db->select($item, "Institutions", $data, "or");
		}


		//This method returns the donation data
		public function getDonationData($item, $data){
			return $this->db->select($item, "Institutions_donation_data", $data);
		}


		//This function register an institution 
		public function registerInstitution($rawData){
			$result=array(
				'name'=>false,
				'email'=>false,
				'latitude'=>false,
				'longitude'=>false,
				'description'=>false,
				'cnpj'=>false,
				'image'=>false,
				'validation'=>false,
				'successfull'=>false
			);
		
			$data=$this->validateRawData($rawData);

			$name=isset($data['name']) ? $data['name'] : "";
			$email=isset($data['email']) ? $data['email'] : "";
			$latitude=isset($data['latitude']) ? $data['latitude']: "";
			$longitude=isset($data['longitude']) ? $data['longitude']: "";
			$description=isset($data['description']) ? $data['description']: "";
			$cnpj=isset($data['cnpj']) ? $data['cnpj']: "";
			$image=isset($data['image']) ? $data['image']: "";
			
			$nameValidation=$this->isValidName($name);
			$emailValidation=$this->isValidEmail($email);
			$latitudeValidation=$this->isValidLatLong($latitude);
			$longitudeValidation=$this->isValidLatLong($longitude);
			$descriptionValidation=$this->isValidDescription($description);
			$cnpjValidation=$this->isValidCNPJ($cnpj);
			$imageValidation=$this->checkBase64Image($image);

			if($nameValidation){
				$result['name']=true;
			}
			if($emailValidation){
				$result['email']=true;
			}
			if($latitudeValidation){
				$result['latitude']=true;
			}
			if($longitudeValidation){
				$result['longitude']=true;
			}
			if($descriptionValidation){
				$result['description']=true;
			}			
			if($cnpjValidation){
				$result['cnpj']=true;
			}
			if($imageValidation){
				$result['image']=true;
			}
			
			$validation=($nameValidation and $emailValidation and $latitudeValidation and 
			$longitudeValidation and $descriptionValidation and $cnpjValidation and $imageValidation);

			if($validation){
				$result['validation']=true;

				$cnpjBind=array("cnpj"=>$cnpj);
				$institutionsFound=$this->db->count("*", "Institutions", $cnpjBind);
				if($institutionsFound==0){
					$imagePath="uploads/institutions/";
					$imagName=md5(uniqid()).".png";

					$dataBind=array(
						"name"=>$name,
						"email"=>$email,
						"image"=>$imagePath.$imagName,
						"latitude"=>$latitude,
						"longitude"=>$longitude,
						"description"=>$description,
						"cnpj"=>$cnpj
					);

					$this->db->insert('Institutions', $dataBind);
					$this->saveImage($image, $imagePath, $imagName);
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
	

		//Name check
		public function isValidName($name){
			$result=false;
			if(strlen(trim($name))>0){
				$result=true;
			}
			return $result;
		}	
		
			
		//Email check	
		public function isValidEmail($email){
			$result=false;
			if(filter_var($email, FILTER_VALIDATE_EMAIL)){
				$result=true;
			}
			return $result;
		}	

				
		//Description check
		public function isValidDescription($description){
			$result=false;
			if(strlen(trim($description))>0){
				$result=true;
			}
			return $result;
		}	


		//Latitude, longitude check
		public function isValidLatLong($value){
			return is_float($value);
		}	
		

		//CNPJ check
		public function isValidCNPJ($cnpj){
			//The validation must be implemented correctly
			$result=false;
			if(strlen(trim($cnpj))>0){
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

