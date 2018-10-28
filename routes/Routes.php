<?php

	require_once (__DIR__)."/../controller/Controllers.php";
	require_once (__DIR__)."/config.php";

	class Routes{
		
		private $defaultController;
		private $usersController;
		private $institutionsController;
		private $data;
		private $paths;

		
		public function __construct(){
			$this->defaultController=new DefaultController();
			$this->usersController=new UsersController();
			$this->institutionsController=new InstitutionsController();
			$this->paths=$this->getPaths();
		}
		
		
		public function execute(){
			return $this->action();	
		}
		
		
		public function action(){
			$action=isset($this->paths[0]) ? $this->paths[0] : null;
			switch($action){		
				case "GET":
					$this->data=$_GET;
					$this->get();
					break;
				case "POST":
					$this->data=json_decode(file_get_contents("php://input"), true);
					$this->post();
					break;
				default:
					$this->defaultController->fail("Request method not set");
					break;
			}
		}
		
		
		public function get(){
			$controller=$this->institutionsController;
			$context=isset($this->paths[1]) ? $this->paths[1] : null;
			switch($context){		
				case "INSTITUTIONS":
					$this->getInstitutions();
					break;
				case "USER":
					break;
				default:
					$this->defaultController->fail("Can't get nothing");
					break;
			}
		}
		
		
		public function post(){
			$context=isset($this->paths[1]) ? $this->paths[1] : null;
			switch($context){		
				case "INSTITUTIONS":
					break;
				case "USER":
					$this->postUsers();
					break;
				default:
					$this->defaultController->fail("Can't post nothing");
					break;
			}			
		}
			
					
		private function getInstitutions(){
			$controller=$this->institutionsController;
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
		
		
		private function postUsers(){
			$context=isset($this->paths[2]) ? $this->paths[2] : null;
			$controller=$this->usersController;
			switch($context){		
				case "LOGIN":
					$controller->login($this->data);
					break;
				case "LOGOUT":
					$controller->logout($this->data);
					break;
				case "SIGNUP":
					$controller->signup($this->data);
					break;
				default:
					$this->defaultController->fail("Can't post nothing");
					break;
			}	
		}
		
		
		private function getPaths(){
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
