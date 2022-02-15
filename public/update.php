<?php 
include('../includes/initialize.php');

$u1 = new User();

//echo $id;

if(isset($_POST['submit'])){
        try{
                $id= $_GET['user_id'];
                $u1->setUser_id($id);
                $u1->setFirstname('Omuse');
                $u1->setLastname('Kianu');
                $u1->setUsername('Kisawa');
                $u1->setPhone('07324516517');
                $u1->setEmail('okumu@gmail.com');
                $u1->setGender('Male');
                $u1->setRole('Admin');
                $u1->attach_file($_FILES['fileToUpload']);
                $u1->setDateCreated(date("Y-m-d H:i:s"));
                $u1->setPassword("12345");
                $u1->update_img($id);
        }catch(PDOException $e){
                echo $e->getMessage();
        }
}

$user_arr = $u1->getUserById($_GET['user_id']);
echo "<pre>";
print_r($user_arr);
echo "</pre>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
</head>
<body>
<form action="update.php?user_id=<?php echo $user_arr['id'];?>" method="post" enctype="multipart/form-data">
  Select image to upload:
  <br>
  Current File Name: <?php echo $user_arr['pic_name'];?>
  <br>
  <input type="file" name="fileToUpload" id="fileToUpload" >
 
  <input type="submit" value="Upload Image" name="submit">
</form>
        
</body>
</html>