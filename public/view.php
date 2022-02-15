<?php
include('../includes/initialize.php');
$users= new User();

?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <title>Document</title>
</head>
<body>
        <div class="container">
        <table class="table-bordered">
                <thead>
                    <tr>
                     <th scope="col">ID</th>
                     <th scope="col">FirstName</th>
                     <th scope="col">LastName</th>
                     <th scope="col">Username</th>
                     <th scope="col">Phone</th>
                     <th scope="col">Email</th>
                     <th scope="col">Password</th>
                     <th scope="col">Gender</th>
                     <th scope="col">Role</th>
                     <th scope="col">Filename</th>
                     <th scope="col">Date Created</th>
                     <th scope ="col" colspan=2>#</th>
                    </tr>    
                </thead>
                <tbody>
                   <?php
                   $u1 = $users->getAllUsers();
                   
                   foreach($u1 as $user){
                      echo "<tr class ='col'>
                      <td>$user[id]</td>
                      <td>$user[fname]</td>
                      <td>$user[lname]</td>
                      <td>$user[uname]</td>
                      <td>$user[phone]</td>
                      <td>$user[email]</td>
                      <td>$user[pass]</td>
                      <td>$user[gender]</td>
                      <td>$user[role]</td>
                      <td><img class='rounded-circle' src='images/$user[pic_name]'width = '100' height='100'></td>
                      <td>$user[date_created]</td>
                      <td><a href='delete.php?user_id=$user[id]'>Delete</a></td>
                      <td><a href='update.php?user_id=$user[id]'>Update</a></td>
                      </tr>"
                      ;     
                   }
                   ?>     
                </tbody>
        </table>
        </div>
        <!--Table to display input-->
        
</body>
</html>