<?php
    require_once (__DIR__)."/Session.php";

    class Middleware{
        
        private $session;
        private $authenticated;
        private $id;
        private $user;

        public function __construct(){
            $this->session=new Session();
            $this->authenticated=false;
        }


        //This function verify if user is authenticated
        public function auth($sessionId){
            $sessionValidation=$this->session->sessionIsValid($sessionId);
            if($sessionValidation){
                $this->id=$sessionId;
                $this->authenticated=true;
                $this->session->sessionResume($sessionId);
            }
        }


        //This function executes the callback functions
        public function execute($callbackSucess){
            if($this->authenticated){
               return call_user_func($callbackSucess);
            }
           header("HTTP/1.1 401 Unauthorized");
        }

        
        //This function returns the session id
        public function getId(){
            return $this->id;
        }


        //This function returns the user email        
        public function getUser(){
            return  $this->session->getUser();
        }
    }

?>