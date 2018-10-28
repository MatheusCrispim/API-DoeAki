<?php 
	require_once (__DIR__)."/../model/UsersModel.php";
	require_once (__DIR__)."/../view/PostView.php";
	
	
	class UsersController{
	
		private $model;
		private $postView;
		
		public function __construct(){
			$this->model=new UsersModel();
			$this->postView=new PostView();
		}
		
		public function login($data){
			$this->postView->result($this->model->login($data));
		}	

		public function signup($data){
			$this->postView->result($this->model->signup($data));
		}			
		
		public function fail($message){
			$this->postView->fail($message);
		}
		
		
	}

?>
