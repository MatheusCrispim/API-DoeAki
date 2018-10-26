<?php 
	require_once (__DIR__)."/../model/InstitutionsModel.php";
	require_once (__DIR__)."/../view/GetView.php";
	
	
	class InstitutionsController{
	
		private $model;
		private $getView;
		
		public function __construct(){
			$this->model=new InstitutionsModel();
			$this->getView=new GetView();
		}

		public function getNearbyInstitutions($data){
			$this->getView->list($this->model->getNearbyInstitutions($data));
		}
		
		public function getInstitutions($data){
			$this->getView->list($this->model->getInstitutions("*", $data));
		}
		
		public function fail($message){
			$this->getView->fail($message);
		}
	}

?>
