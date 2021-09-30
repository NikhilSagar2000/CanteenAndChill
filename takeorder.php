<?php include 'connection.php';
session_start();
if(isset($_SESSION['login'])){
?>
<?php
    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['addnp'])){
         $_SESSION['cname']=ucwords($_POST['cname']);
         $_SESSION['cphone']=$_POST['cphone'];
    while(true){
    $_SESSION['cid']=rand(10000,99999);
    $cidquery="select * from customer where customer_id = ".$_SESSION['cid']." AND username ='".$_SESSION['login']."'";
    $cidresult=mysqli_query($conn,$cidquery);
    $count=mysqli_num_rows($cidresult);
    if($count==0){
      break;
    }
    }
    $insert1="insert into customer(username,customer_id,customer_name,customer_phone) VALUES('".$_SESSION['login']."',".$_SESSION['cid'].",'".$_SESSION['cname']."','".$_SESSION['cphone']."')";
    if(mysqli_query($conn,$insert1)){
    header("location:takeorder2.php");
    }  
  }
    ?>
   
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canteen&Chill</title>
    <link rel="stylesheet" type="text/css" href="css/takeorders.css">
</head>
<body>

    <div class="header">
        <div class="logo">
        <a href="home.php"> <img src="images/logoname.JPG"></a>
        </div>
    </div>
    <div class="topnav">
       <div class="tabs">
           <a href="home.php"><b>Home</b></a>
           <a href="addremove.php"><b>Add/Remove Items</b></a>
           <a href="edit.php"><b>Edit Items</b></a>
           <a href="takeorder.php" id="selected"><b>Take orders</b></a>
           <a href="totalsales.php"><b>Total Sales</b></a>
       </div>
    </div><br>
    <div class="details">
        <div class="head">
          <h1> <span style="border :3px solid rgb(51, 47, 47);border-radius:5px;background-color:rgb(51, 47, 47);color:whitesmoke;">
                         Enter Details  </span> </h1>
        </div>  <br><br>
        <div class="NandP">
        <form action="" method="POST" autocomplete="off" >
                     <label for="cname" ><b style="margin-left:-85px;">Customer's Name</b></label><br>
                     <input type="text" name="cname"  required>
                     <br><br>
                     <label for="cphone" ><b style="margin-left:-50px;">Customer's PhoneNo.</b></label><br>
                     <input type="text" name="cphone" pattern="[6-9]{1}[0-9]{9}" minlength="10" maxlength="10" required><br><br>
                   <br>  <input type="submit" value="Continue" id="submit" name="addnp" onclick="return confirm('Are you sure you want to Continue?');" ><br><br>
        </form>
        </div>  
    </div>
    <?php
   if(isset($_POST['placeorder'])){
       $sql2="UPDATE customer SET total = ".$_SESSION['grandtotal'].",date = CURDATE(),total_items = ".$_SESSION['totalitems']."  WHERE customer_id = ".$_SESSION['cid']." AND username = '".$_SESSION['login']."'";
       if(mysqli_query($conn,$sql2)){
       unset($_SESSION['cid']);
       unset($_SESSION['cname']);
       unset($_SESSION['cphone']);
       unset($_SESSION['grandtotal']);
       unset($_SESSION['totalquantity']);
       unset($_SESSION['totalitems']);
       ?>
       <script>alert('Order Placed.');</script>;
       <?php
       }
       else{
         ?>
         <script>alert('error');</script>;
         <?php
       }
   }
?>
<?php
}
else{
  header("location:login.php");
}
?>
</body>
</html>

   