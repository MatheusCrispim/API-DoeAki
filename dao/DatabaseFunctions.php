<?php

#########################################
# Author: Matheus Guedes Crispim        #
# E-mail: matheus.guedes@dce.ufpb.br    #
# Date: 28/04/2016                      #
#########################################
	
require_once "Connection.php";

class DatabaseFunctions{
	
	private static $dbh;
	private $cmmd;
	
	public function __construct(){
		$db=new Connection();
		self::$dbh=$db->getConnection();				
	}
			
	//create, drop, insert, select, count, update, delete 
	public function createTable($tb, $data, $engine, $charset){
		$slice=$this->organize($data, ", ", "data");
		$this->cmmd="CREATE TABLE IF NOT EXISTS `".$tb."` (".$slice.") ENGINE=".$engine."  DEFAULT CHARSET=".$charset.";";
		return $this->execute($this->cmmd);
	}
		
		
	public function dropTable($tb){
		$this->cmmd="DROP TABLE `".$tb."`;";
		return $this->execute($this->cmmd);
	}
		
		
	public function insert($tb, $data){
		$slice=$this->organize($data, ", ", "key");
		$slice1=$this->organize($data, ", ", "key", ":");
		$this->cmmd="INSERT INTO `".$tb."` (".$slice.") VALUES (".$slice1.");";
		return $this->execute($this->cmmd, $data);
	}
		
		
	public function select($item, $tb, $where=array(), $operator=""){
		$this->cmmd="";
		if(!empty($where)){
			$slice=$this->organize($where, " $operator ", "equal_key", ":");
			$this->cmmd="SELECT ".$item." FROM `".$tb."` WHERE ".$slice.";";
		}else{
			$this->cmmd="SELECT ".$item." FROM `".$tb."`;";
		}
		$search=$this->execute($this->cmmd, $where);
		return $search->fetchAll();
	}
		
		
	public function count($item, $tb, $where=array(), $op=""){
		$item="COUNT(".$item.")";
		$countArr=$this->select($item, $tb, $where, $op);

		foreach($countArr as $count){
			return get_object_vars($count)[$item];
		}
	}


	public function update($tb, $data, $where, $operator="" ){
		$pre=":_";
		$slice=$this->organize($data, ", ", "equal_key", ":");
		$slice1=$this->organize($where, " $operator ", "equal_key", $pre);
		$this->cmmd="UPDATE `".$tb."` SET ".$slice." WHERE ".$slice1.";";

		//rewrite the array index
		foreach($where as $key=>$here){
			unset($where[$key]);
			$where[$pre.$key]=$here;
		}
		$this->execute($this->cmmd, array_merge($data, $where));
	}


	public function delete($tb, $where, $operator=""){
		$slice=$this->organize($where, " $operator ", "equal_key", ":");
		$this->cmmd="DELETE FROM `".$tb."` WHERE ".$slice.";";
		return $this->execute($this->cmmd, $where);
	}


	//executing and formatting methods
	private function exec($cmmd){
		try {
			$exec=self::$dbh->exec($cmmd);
			
			if($exec->errorInfo()[2]!=null){
				 die(print_r($exec->errorInfo(), true));		
			}
			return $exec;
			
		} catch (PDOException $e) {
				die("DB ERROR: ". $e->getMessage());
		}						
	}
		
		
	public function execute($cmmd, $data=array()){	
		try {
			$prep=self::$dbh->prepare($cmmd);
			$prep->execute($data);
			
			if($prep->errorInfo()[2]!=null){
				die(print_r($prep->errorInfo(), true));		
				}
			return $prep;	

			} catch (PDOException $e) {
				header("HTTP/1.0 404 Not Found");
				die("ERROR: Malformed request\n". $e->getMessage());
			}		
		}

	
	//Don't try understand this, just use
	private function organize($data, $sep, $use, $pre=""){
		$fv=0;
		$c="";
		$use=strtoupper($use);
		if(!empty($data)){
			if($use=="KEY"){
				foreach($data as $key=>$d){
					if($fv==0){
						$c.=$pre.$key;
					}else{
						$c.=$sep.$pre.$key;
					}
					$fv++;
				}
			}else if($use=="DATA"){
				foreach($data as $d){
					if($fv==0){
						$c.=$d;
					}else{
						$c.=$sep.$d;
					}
					$fv++;
				}
			}else if($use=="EQUAL_KEY"){
				foreach($data as $key=>$d){
					if($fv==0){
						$c.=$key." LIKE ".$pre.$key;
					}else{
						$c.=$sep.$key." LIKE ".$pre.$key;
					}
					$fv++;
				}				
			}//end else if
		}//end if
		return $c;
	}
		
}
	
?>

