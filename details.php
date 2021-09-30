<?php
include 'connection.php';
session_start();
if(isset($_SESSION['login'])){
?>
<?php
 // $cname="";
 // $cid=0;
 // if(isset($_GET['customerid']) && isset($_GET['customername'])){
 //     $cname=$_GET['customername'];
  //    $cid=$_GET['customerid'];
  //}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canteen&Chill</title>
    <link rel="stylesheet" type="text/css" href="css/totalsales.css">
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
           <a href="takeorder.php"><b>Take orders</b></a>
           <a href="totalsales.php" id="selected"><b>Total Sales</b></a>
       </div>
    </div>
    <br>
    <div class="details">
        <div class="head">
          <h1> <span style="border :3px solid rgb(51, 47, 47);border-radius:5px;background-color:rgb(51, 47, 47);color:whitesmoke;">
                        <?php echo $_GET['customername'];?>'s Order Details </span> </h1>
        </div>
    </div>
   <?php
        $sql="select * from customer_order where id = ".$_GET['customerid']." AND username='".$_SESSION['login']."'";
        $result=mysqli_query($conn,$sql);
        $count=mysqli_num_rows($result);
        if($count>0){
            echo "<table>
            <tr>
            <th>S No.</th>
            <th>Itemname</th> 
            <th>Price</th>                  
            <th>Quantity</th>
            <th>Total</th>
            </tr>";
            $i=1;      
            while($row = mysqli_fetch_array($result))
              {
                echo "<tr>";
                echo "<td>" . $i . "</td>";
                echo "<td>" . $row['itemname'] . "</td>";
                echo "<td>" .$row['price']. "</td>"; 
                echo "<td>" . $row['itemquantity'] . "</td>";
                echo "<td>Rs.&nbsp;&nbsp;".  $row['total'] . "</td>";
                echo "</tr>";
                $i++;
             }
            echo "</table>";
            echo "<br><br><br>";
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
