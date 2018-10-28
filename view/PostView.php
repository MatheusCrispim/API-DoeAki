<?php
	
	header('Content-Type: application/json');

	class PostView{
		
		public function result($result){
			echo "[".json_encode($result, JSON_UNESCAPED_UNICODE)."]";
		}
	
		public function fail($message){
			header("HTTP/1.0 404 Not Found");
			die("ERROR: ".$message);
		}
		
	}


?>
