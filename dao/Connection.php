<?php

require_once 'config.php';

class Connection{

	private static $instance;

	public static function getConnection(){

		if(!isset(self::$instance)){

			try {
				//this connection is opened by setting the utf-8 charset
				self::$instance = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
				self::$instance->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			} catch (PDOException $e) {
				echo $e->getMessage();
			}

		}

		return self::$instance;
	}
 	
}
