<?php
	
	header('Content-Type: application/json');

	class GetView{
		
		public function list($results){
			echo "[";
			foreach($results as $key=>$result){
				echo json_encode($result, JSON_UNESCAPED_UNICODE);
				
				if($key!=count($results)-1){
					echo ",";
				}
			}
			echo "]";
		}
		
		
		public function fail($message){
			echo "A";
			header("HTTP/1.0 404 Not Found");
			die("ERROR: ".$message);
		}
		
	}


?>
