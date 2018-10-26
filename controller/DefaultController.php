<?php 
	require_once (__DIR__)."/../view/GetView.php";
	
	
	class DefaultController{

		private $getView;
		
		public function __construct(){
			$this->getView=new GetView();
		}
		
		public function fail($message){
			$this->getView->fail($message);
		}
		
		
	}

?>
