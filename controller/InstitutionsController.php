<?php 
	require_once (__DIR__)."/../model/InstitutionsModel.php";
	require_once (__DIR__)."/../view/GetView.php";
	require_once (__DIR__)."/../view/PostView.php";

	
	class InstitutionsController{
	
		private $model;
		private $getView;
		private $postView;
		
		public function __construct(){
			$this->model=new InstitutionsModel();
			$this->getView=new GetView();
			$this->postView=new PostView();
		}

		public function getNearbyInstitutions($data){
			$this->getView->list($this->model->getNearbyInstitutions($data));
		}
		
		public function getInstitutions($item, $data){
			$this->getView->list($this->model->getInstitutions($item, $data));
		}

		public function getDonationData($item, $data){
			$this->getView->list($this->model->getDonationData($item, $data));
		}

		public function registerInstitution($data){
			$this->postView->result($this->model->registerInstitution($data));
		}
		
		public function fail($message){
			$this->getView->fail($message);
		}
	}

?>
