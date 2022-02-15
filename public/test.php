<?php 
include('../includes/initialize.php');
$user1 = new User();
if(isset($_POST['submit'])){
  try{
    $d1 = date("Y-m-d H:i:s");
    $user1->setFirstname('John');
    $user1->setLastname('Kamau');
    $user1->setUsername('Aladwa');
    $user1->setPhone('07324516517');
    $user1->setEmail('okumu@gmail.com');
    $user1->setGender('Male');
    $user1->setRole('Admin');
    $user1->attach_file($_FILES['fileToUpload']);
    $user1->setDateCreated($d1);
    $user1->setPassword("12345");
    $user1->save();
    print_r($user1->errors);
  }catch(PDOException $e){
    echo $e->getMessage();
  }
  
  
  


}


?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Test
        </title>
</head>
<body>
<form action="test.php" method="post" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit">
</form>
</body>
</html>
<?php



?>