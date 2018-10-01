<?php
	
	require_once (__DIR__)."/../controller/InstitutionController.php";
	require_once (__DIR__)."/config.php";

	class Routes{
		
		private $institutionController;
		private $data;
		private $paths;

		
		public function __construct(){
			$this->institutionController=new InstitutionController();
			$this->paths=$this->getPaths();
			$this->data=json_decode(file_get_contents("php://input"), true);
		}
		
		
		public function execute(){
			return $this->action();	
		}
		
		
		public function action(){
			$controller=$this->institutionController;
			$action=isset($this->paths[0]) ? $this->paths[0] : null;
			switch($action){		
				case "GET":
					$this->get();
					break;
				case "POST":
					break;
				default:
					$controller->fail("Request method not set");
					break;
			}
		}

		
		public function get(){
			$controller=$this->institutionController;
			$context=isset($this->paths[1]) ? $this->paths[1] : null;
			switch($context){		
				case "INSTITUTION":
					$this->getInstitutions();
					break;
				case "USER":
					break;
				default:
					$controller->fail("Can't get nothing");
					break;
			}
		}
			
					
		private function getInstitutions(){
			$controller=$this->institutionController;
			$searchType=isset($this->paths[2]) ? $this->paths[2] : null;
			switch($searchType){		
				case "NEARBY":
					$controller->getNearbyInstitutions($this->data);
					break;
				case "NORMAL":
					$controller->getInstitutions($this->data);
					break;
				default:
					$controller->fail("Can't get nothing");
					break;
			}
		}
		
		
		public function getPaths(){
			$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);
			$paths=explode('/', $request_uri[0]);
			$filteredPaths=array();
			
			foreach($paths as $path){
				if(trim($path) != ''){
					array_push($filteredPaths, strtoupper($path));
				}	
			}
			
			$apiPath=explode('/', APIPATH);
			$filteredPaths=array_diff($filteredPaths, $apiPath);
			$filteredPaths=array_values($filteredPaths);
			
			return $filteredPaths;
		}
						
	}

?>
