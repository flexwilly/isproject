<?php
include('initialize.php');

class User{
        protected $tableName = 'users';
        private $user_id;
        private $firstname;
        private $lastname;
        private $username;
        private $phone;
        private $email;
        private $password;
        private $gender;
        private $role;
        private $dbConn;

        //image related data attributes
        private $filename;
        private $filesize;
        private $filetype;
        private $temp_path;
        protected $upload_dir = "images";
        private $date_created;
        //array of errors that may arise during file movement.
        public $errors=array();
  
        protected $upload_errors = array(
            UPLOAD_ERR_OK 				=> "No errors.",
            UPLOAD_ERR_INI_SIZE  	=> "Larger than upload_max_filesize.",
            UPLOAD_ERR_FORM_SIZE 	=> "Larger than form MAX_FILE_SIZE.",
            UPLOAD_ERR_PARTIAL 		=> "Partial upload.",
            UPLOAD_ERR_NO_FILE 		=> "No file.",
            UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.",
            UPLOAD_ERR_CANT_WRITE => "Can't write to disk.",
            UPLOAD_ERR_EXTENSION 	=> "File upload stopped by extension."
        );
       
        //Constructor
        public function __construct()
        {
                //create an instance of the DBConnect Class
                $db = new DBConnect();
                //open connection to the database
               $this->dbConn =  $db->open_connection();
        }


        //encapsulating the properties
        public function setUser_id($user_id) { $this->user_id = $user_id; }
        public function getUser_id() { return $this->user_id; }
        public function setFirstname($firstname) { $this->firstname = $firstname; }
        public function getFirstname() { return $this->firstname; }
        public function setLastname($lastname) { $this->lastname = $lastname; }
        public function getLastname() { return $this->lastname; }
        public function setUsername($username) { $this->username = $username; }
        public function getUsername() { return $this->username; }
        public function setPhone($phone) { $this->phone = $phone; }
        public function getPhone() { return $this->phone; }
        public function setEmail($email) { $this->email = $email; }
        public function getEmail() { return $this->email; }
        public function setPassword($password) { $this->password = $password; }
        public function getPassword() { return $this->password; }
        public function setGender($gender) { $this->gender = $gender; }
        public function getGender() { return $this->gender; }
        public function setRole($role) { $this->role = $role; }
        public function getRole() { return $this->role; }

        //File related encapsulated functions
        public function setFileName($filename) { $this->filename = $filename; }
        public function getFileName() { return $this->filename; }

        public function setFiletype($filetype) { $this->filetype = $filetype; }
        public function getFiletype() { return $this->filetype; }
        
        public function setFileSize($filesize) { $this->filesize = $filesize; }
        public function getFileSize() { return $this->filesize; }
        
        public function setTempPath($temp_path) { $this->temp_path = $temp_path; }
        public function getTempPath() { return $this->temp_path; }

        public function setDateCreated($date_created) { $this->date_created = $date_created; }
        public function getDateCreated() { return $this->date_created; }

        //create function to create a user
        public function add_user(){
            try{
                $sql = 'INSERT INTO '.$this->tableName. ' VALUES(null, :fname, :lname, :uname, :phone, :email, :pass, :gender, :role, :pic_name, :date_created)';
                $stmt = $this->dbConn->prepare($sql);
                $stmt->bindParam(':fname',$this->firstname);
                $stmt->bindParam(':lname',$this->lastname);
                $stmt->bindParam(':uname',$this->username);
                $stmt->bindParam(':phone',$this->phone);
                $stmt->bindParam(':email',$this->email);
                $stmt->bindParam(':pass',$this->password);
                $stmt->bindParam(':gender',$this->gender);
                $stmt->bindParam(':role',$this->role);
                $stmt->bindParam(':pic_name',$this->filename);
                $stmt->bindParam(':date_created',$this->date_created);
                if($stmt->execute()){
                    return true;
        
                }else{
                    return false;
                }

            }catch(PDOException $e){
                echo $e->getMessage();
            }
            
     
        }
        //function to update user details
        public function updateUser(){
            $stmt = $this->dbConn->prepare('UPDATE '.$this->tableName. ' SET fname = :fname, lname = :lname, 
            uname = :uname, phone = :phone, email = :email, pass = :pass, gender = :gender, role = :role , pic_name = :pic_name ,date_created = :date_created  WHERE id = :id');
            
            $stmt->bindParam(':fname',$this->firstname);
            $stmt->bindParam(':lname',$this->lastname);
            $stmt->bindParam(':uname',$this->username);
            $stmt->bindParam(':phone',$this->phone);
            $stmt->bindParam(':email',$this->email);
            $stmt->bindParam(':pass',$this->password);
            $stmt->bindParam(':gender',$this->gender);
            $stmt->bindParam(':role',$this->role);
            $stmt->bindParam(':pic_name',$this->filename);
            $stmt->bindParam(':date_created',$this->date_created);
            $stmt->bindParam(':id',$this->user_id);

            if($stmt->execute()){
                return true;
            }else{
                return false;
            }

            
        }

               //function to get all users
        public function getAllUsers(){
                try{
                    $stmt = $this->dbConn->prepare('SELECT * FROM '.$this->tableName);
                    $stmt->execute();
                    //create a variable array that will hold all the associative array values retrieved from the Database
                    $all_users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    //return the values in associative array format.
                    return $all_users;
                }catch(PDOException $e){
                    echo $e->getMessage();
                }
                
        }
    
            //function to delete a user based on id
        public function deleteUser($id){
                try{
                    $stmt = $this->dbConn->prepare('DELETE FROM '.$this->tableName . ' WHERE id = :user_id');
                    $stmt->bindParam(':user_id',$this->user_id);
                    
                    if($stmt->execute(['user_id'=>$id])){
                        return true;
                    }else{
                        return false;
                    } 
                }catch(PDOException $e){
                    echo $e->getMessage();
                }
        }
    
              //function to get users by id
        public function getUserById($id){
                $stmt = $this->dbConn->prepare('SELECT * FROM '.$this->tableName. ' WHERE id = :id');
                $stmt->execute(['id'=> $id]);
                $single_user = $stmt->fetch();
                //return the row containing the id 
                return $single_user;
        } 
    
            //function to get user by email address(Will be used to compare email from form with email in db)
        public function getUserByEmail($email){
                //Query to select user based on email
                $stmt = $this->dbConn->prepare('SELECT * FROM '.$this->tableName.' WHERE email = :email');
                $stmt->execute(['email'=> $email]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                return $user;
        }
    
        //Functions to handle the complete process of saving an image and its releveant information into the database.
        //1.Pass in $_FILE(['uploade file ']) as an argument 
        //This function sets the values of the file ie tmp_path, filename, filetype
        public function attach_file($file){
            // Perform error checking on the form parameters
            if(!$file || empty($file) || !is_array($file)) {
                // error: nothing uploaded or wrong argument usage
                $this->errors[] = "No file was uploaded.";
                return false;
            } elseif($file['error'] != 0) {
                // error: report what PHP says went wrong
                $this->errors[] = $this->upload_errors[$file['error']];
                return false;
            } else {
                // Set object attributes to the form parameters.
                $this->setTempPath($file['tmp_name']);
                $this->setFileName(basename($file['name']));
                $this->setFiletype($file['type']);
                $this->setFileSize($file['size']);
                // Don't worry about saving anything to the database yet.
               
                return true;
    
            }
        }

        //2.Setting and upload folder path
        public function image_path() {
            return $this->upload_dir.DS.$this->getFileName();
        }

        //3. Save the file into the correct folder.
        public function save(){
          // Can't save if there are pre-existing errors
		  if(!empty($this->errors)) { return false; }

          // Can't save without filename and temp location
          if(empty($this->getFileName()) || empty($this->getTempPath())) {
		    $this->errors[] = "The file location was not available.";
		    return false;
		  }

          // Determine the target_path i.e 
		  $target_path = SITE_ROOT .DS. 'public' .DS. $this->upload_dir .DS. $this->getFileName();

          
		  // Make sure a file doesn't already exist in the target location
		  if(file_exists($target_path)) {
		     $this->errors[] = "The file {$this->getFileName()} already exists.";
		    return false;
		  }

          // Attempt to move the file 
			if(move_uploaded_file($this->getTempPath(), $target_path)) {
                // Success
                  // Save a corresponding entry to the database
                  if($this->add_user()) {
                      // We are done with temp_path, the file isn't there anymore
                      $myTempPath = $this->getTempPath();
                      unset($myTempPath);
                      return true;
                  }
              } else {
                  // File was not moved.
              $this->errors[] = "The file upload failed, possibly due to incorrect permissions on the upload folder.";
              return false;
              }


        }
        //4. Update existing image
       public function update_img($id){
             //get user by id
            $user = $this->getUserByID($id);  

            // Can't save if there are pre-existing errors
		  if(!empty($this->errors)) { return false; }

          // Can't save without filename and temp location
          if(empty($this->getFileName()) || empty($this->getTempPath())) {
		    $this->errors[] = "The file location was not available.";
		    return false;
		  }
          //path to the file in the images folder
          $initial_path = SITE_ROOT .DS. 'public' .DS. $this->upload_dir .DS. $user['pic_name'];
          // Determine the target_path i.e 
		  $target_path = SITE_ROOT .DS. 'public' .DS. $this->upload_dir .DS. $this->getFileName();

          
		  // Make sure a file doesn't already exist in the target location if it exists remove it
		  if(file_exists($initial_path)) {
		    $this->errors[] = "The file {$this->getFileName()} already exists.";
            unlink($initial_path);
		  }
           // Attempt to move the file 
			if(move_uploaded_file($this->getTempPath(), $target_path)) {
                // Success
                  // Save a corresponding entry to the database
                  if($this->updateUser()) {
                      // We are done with temp_path, the file isn't there anymore
                      $myTempPath = $this->getTempPath();
                      unset($myTempPath);
                      return true;
                  }
              } else {
                  // File was not moved.
              $this->errors[] = "The file upload failed, possibly due to incorrect permissions on the upload folder.";
              return false;
              }



       }
        //5. Remove an image
         /**Delete Image */
        public function destroy_img($id){
            #Target path
            $target_path = SITE_ROOT.DS.'public'.DS.$this->image_path();
            $user=$this->getUserByID($id);
            //remove image first from targe path
            if(unlink($target_path.$user['pic_name'])){     
            $this->deleteUser($user['id']);
    
            }else{
            //database delete failed
            return false;
            $this->error[] = "Delete failed";
            //echo "Delete Failed";
        }
  }
       
 
        //functions to encrypt password
        //1.Salt Generation
        public function generate_salt($length){
            // Not 100% unique, not 100% random, but good enough for a salt
            // MD5 returns 32 characters
            $unique_random_string = md5(uniqid(mt_rand(), true));
            // Valid characters for a salt are [a-zA-Z0-9./]
            $base64_string = base64_encode($unique_random_string);
            // But not '+' which is valid in base64 encoding
            $modified_base64_string = str_replace('+', '.', $base64_string);
            // Truncate string to the correct length
            $salt = substr($modified_base64_string, 0, $length);
            return $salt;
        }

        //2.Encryption of the password(BlowFish)
        public function password_encrypt($password){
            $hash_format = "$2y$10$";   // Tells PHP to use Blowfish with a "cost" of 10
            $salt_length = 22; 			// Blowfish salts should be 22-characters or more
            $salt = $this->generate_salt($salt_length);//call the generate salt function with the length of the salt you intend to use preferrably(22characters)
            $format_and_salt = $hash_format . $salt;
            $hash = crypt($password, $format_and_salt);
            return $hash;
        }

        //3.Function that compares the inserted password with what is in the db
        public function password_check($password,$existing_hash){
            // existing hash contains format and salt at start
            $hash = crypt($password, $existing_hash);
            if ($hash === $existing_hash) {
                return true;
            } else {
                return false;
            }
        }


        //4.Function that attempts to login the user
        public function attempt_login($email,$password){
            //log ins after it confirms if the email and password match what is in the db
            $user = $this->getUserByEmail($email);
            if($user){
                //found the user now lets check password
                if($this->password_check($password,$user['pass'])){
                    //password matches what is in the db
                    return $user;
                }else{
                    //password does not match
                    return false;
                }
            }

        }


       
}
$u1 = new User();

?>