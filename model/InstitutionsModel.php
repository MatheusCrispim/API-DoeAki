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
		
	}
?>

