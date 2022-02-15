<?php
include('initialize.php');

class Session{
      private $logged_in = false;
      public $id;
      public $role;
      public $fname;
      public $lname;
      public $message;



        public function __construct()
        {
                
        }

      //function to get the loggin status
      public function is_logged_in() {
        return $this->logged_in;
      }    

      //function to set the session values
      public function login($user) {
        // database should find user based on username/password
        if($user){
          $this->id = $_SESSION['id'] = $user->id;
          $this->role = $_SESSION['role'] = $user->role;
          $this->fname = $_SESSION['fname']= $user->fname;
          $this->lname = $_SESSION['lname']=$user->lname;
          //after login successful set the status to true
          $this->logged_in = true;
        }
      }


}

?>