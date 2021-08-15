<?php include 'connection.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canteen&Chill</title>
    <link rel="stylesheet" type="text/css" href="css/createaccount.css">
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
                <br><br><br>
                <b style="font-size:25px;margin-left:-260px;">Username</b><br>
                <input type="text" id="ID" name="uname"  class="cm_uid" minlength="2" maxlength="30" required><br><br>
                
                <b style="font-size:25px;margin-left:-260px;">Password</b><br>
                <input type="password" id="pass" name="pass"  class="cm_uid" minlength="8" maxlength="30" required><br><br>
                
                <b style="font-size:25px;margin-left:-160px;">Confirm Password</b><br>
                <input type="password" id="pass" name="confirmpass"  class="cm_uid" required><br><br>
                <br>
                <?php
                if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])){
                    $username=strtolower($_POST['uname']);
                    $pass=strtolower($_POST['pass']);
                    $cpass=strtolower($_POST['confirmpass']);
                if ( preg_match('/\s/',$username) ||  preg_match('/\s/',$pass)){
                        echo "<b style='color:red;margin-left:-70px'>No whitespace allowed in username and password</b><br><br>";  
                } else {
                        
                    $sql1="select * from login where username='".$username."'";
                    $result1=mysqli_query($conn,$sql1);
                    $count1=mysqli_num_rows($result1);
                    $pass=strtolower($_POST['pass']);
                    $cpass=strtolower($_POST['confirmpass']);
                    if($count1==0){
                        if($pass == $cpass){
                           $sql2="insert into login(username,password) values('".$username."','".$pass."')";
                           if(mysqli_query($conn,$sql2)){
                            echo '<script>alert("Account created Successfully.\nYou can login now.")</script>';
                           }
                           else{
                               echo '<script>alert("Some error occured.\nPlease try again")</script>';
                           }
                        }
                        else{
                            echo "<b style=\"color:red;margin-left:-60px\">Passwords doesnot match</b><br><br>";
                        }
                    }
                    else{
                        echo "<b style=\"color:red;margin-left:-60px\">Username already exists.</b><br><br>";
                    }
                }
            }
                ?>
                <input type="submit" class="submitbtn" id="login" value="Create Account" name="create" > <br><br>
                <a href="login.php" style="margin-left:-50px"><b>Already have a account? Login</b></a>
            
            
            
            </div>
        </div>
    </form>
                
              