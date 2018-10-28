<?php

require_once (__DIR__)."/../dao/DatabaseFunctions.php";


class Session{

    private $db;
    private $id;
    private $user;

    public function __construct(){
        $this->db=new DatabaseFunctions();
    }


    //This Function Starts a sesion
    public function sessionStart($userEmail){
        $id=md5(uniqid());
        $this->id=$id;

        $data=array("session_id"=>$id, "user_email"=>$userEmail);
        $this->db->insert("Session", $data);

        session_id($id);
        session_start();
    }


    //This function Resume a session
    public function sessionResume($id){
        $validSession=$this->sessionIsValid($id);
        if($validSession){
            $this->id=$id;
            $dataBind=array("session_id"=>$id);
            $this->user=get_object_vars($this->db->select("user_email", "Session",   $dataBind)[0])['user_email'];
            
            session_id($id);
            session_start();    
        }
    }


    //This function destroy a session
    public function sessionDestroy($id){
        $validSession=$this->sessionIsValid($id);
        if($validSession){
            $dataBind=array("session_id"=>$id);
            $this->db->delete("Session", $dataBind);
            session_id($id);
            session_start();    
            session_destroy();
        }
    }


   //This function verify  if a session is valid
    public function sessionIsValid($id){  
        $dataBind=array("session_id"=>$id);
        $foundSession=$this->db->count("*", "Session", $dataBind);
        $result=false;

        if($foundSession>0){
           $result=true;
        }
        return $result;
    }


    //This function returns the user connected
    public function getUser(){
        return $this->user;
    }


    //This function returns the session id
    public function getId(){
        return $this->id;
    }

}

?>