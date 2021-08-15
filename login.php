<?php include 'connection.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canteen&Chill</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
    <div class="header">
        <div class="logo">
        <a href="index.html"><img src="images/logoname.JPG"></a>
        </div>
    </div>
    <br><br><br>
    <form action="" method="POST" autocomplete="off">
        <div class="container">
            <div class="details">
                <br><br><br><br><br> 
                <b style="font-size:25px;margin-left:-260px;">Username</b><br>
                <input type="text" id="ID" name="username" placeholder="Enter Username" class="cm_uid" required><br><br>
                
                <b style="font-size:25px;margin-left:-260px;">Password</b><br>
                <input type="password" id="pass" name="password" placeholder="Enter Password" class="cm_uid" required><br><br>
                <input type="checkbox" onclick="myFunction()" style="margin-left: -250px;"><b>Show Password</b><br><br>
               
            <?php 
                 if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) 
                 {
                       $username=$_POST['username'];
                       $password=$_POST['password'];
                       $sql="select * from login WHERE username = '$username'and password = '$password' ";
                       $result=mysqli_query($conn,$sql);
                       $count = mysqli_num_rows($result);
                       if($count==1)
                       {
                           $_SESSION['login']=$username;
                           header("location: home.php");
                       }
                       else{
                           echo "<i style=\"color:red;margin-left:-50px\" >Username and Password doesn't match.</i><br><br>";
                       }
                 }
            ?>
                
            }
      }
                <input type="submit" class="submitbtn" id="login" value="LOGIN" name="login" > <br><br>
                <a href="createaccount.php" style="margin-left:-40px"><b>Donot have a account? Create one</b></a>
            </div>
        </div>
    </form>
    
        <script>
            function myFunction() {
                var x = document.getElementById("pass");
                if (x.type === "password") {
                  x.type="text";
                } else {
                   x.type="password";
                }
            }
        </script>
         <?php
      
      
        ?>
        
</body>
</html>

          