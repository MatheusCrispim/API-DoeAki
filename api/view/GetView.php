<?php
	
	header('Content-Type: application/json');

	class GetView{
		
		public function list($results){
			foreach($results as $result){
				echo json_encode($result, JSON_UNESCAPED_UNICODE)."fefa253fd04f5712c80e3bf4f4649c64";
			}
		}
		
		
		public function fail($message){
			echo $message;
		}
		
	}


?>
