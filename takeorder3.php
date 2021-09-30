<?php
include 'connection.php';
session_start();
if(isset($_SESSION['cid']) && isset($_SESSION['cname']) && isset($_SESSION['cphone'])){

?>
<?php
if(isset($_POST['cancelorder'])){
  $addquery="select * from customer_order where id=".$_SESSION['cid']." AND username ='".$_SESSION['login']."'";
  
  $addresult=mysqli_query($conn,$addquery);
  while($addrow = mysqli_fetch_array($addresult)){
    $addquantity=$addrow['itemquantity'];
    $addquery2="update menu SET quantity = quantity + ".$addquantity." where itemname='".$addrow['itemname']."' AND username='".$_SESSION['login']."'";
    mysqli_query($conn,$addquery2);
  }
  

  $cancel="DELETE from customer_order where id = ".$_SESSION['cid']." AND username='".$_SESSION['login']."'";
  mysqli_query($conn,$cancel);
  $view="DELETE from customer WHERE customer_id = ".$_SESSION['cid']." AND username='".$_SESSION['login']."'";
  mysqli_query($conn,$view);
  unset($_SESSION['cid']);
  unset($_SESSION['cname']);
  unset($_SESSION['cphone']);
  header("location:takeorder.php");
}
?>
 <?php
                  if(isset($_GET['itemname'])){
                    $itemname=$_GET['itemname'];
                    $del="delete from customer_order where itemname = '$itemname' AND username='".$_SESSION['login']."'";
                    mysqli_query($conn,$del);
                  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canteen&Chill</title>
    <link rel="stylesheet" type="text/css" media="all" href="css/takeorders3.css">
</head>
<body>

    <div class="header">
        <div class="logo">
        <a onclick="alert('Please complete your order first or cancel your order to move to this page.');"> <img src="images/logoname.JPG"></a>
        </div>
    </div>
    <div class="topnav">
       <div class="tabs">
           <a onclick="alert('Please complete your order first or cancel your order to move to this page.');"><b>Home</b></a>
           <a onclick="alert('Please complete your order first or cancel your order to move to this page.');"><b>Add/Remove Items</b></a>
           <a onclick="alert('Please complete your order first or cancel your order to move to this page.');"><b>Edit Items</b></a>
           <a  id="selected"><b>Take orders</b></a>
           <a onclick="alert('Please complete your order first or cancel your order to move to this page.');"><b>Total Sales</b></a>
       </div>
    </div><br>
    <div class="details">
        <div class="head">
          <h1> <span style="border :3px solid rgb(51, 47, 47);border-radius:5px;background-color:rgb(51, 47, 47);color:whitesmoke;">
                         Place Order </span> </h1>
        </div>
        <div class="cdetails" style="width:100%;">
          <div style="width:25%;float:left"> <b>Order Id :- <?php if(isset($_SESSION['cid'])){echo $_SESSION['cid'];}?></b>  </div>
          <div style="width:25%;float:left"><b>Name :- <?php  if(isset($_SESSION['cname'])){ echo $_SESSION['cname'];}?></b> </div>
        <div style="width:25%;float:left"><b>PhoneNo. :- +91&nbsp;&nbsp;<?php  if(isset($_SESSION['cphone'])){ echo $_SESSION['cphone'];}?></b>  </div>     
          <div style="width:25%;float:left"><b>Date :- <?php echo date("d/m/Y")?></b>  </div>     
        </div> <br>
    </div>
    <div class="orderdetails">
        <div class=cancel style="width:20%;float:left;text-align:center">
        <br>
             <form method="POST" action="">
              <input type="submit" value="Cancel Order" name="cancelorder" onclick="return confirm('Are you sure you want to cancel this order?');" style="width:120px;height:25px; background-color:red;color: whitesmoke;font-size: large;border:1px;border-radius:5px;">
             </form>
        </div>
        <div  style="text-align:center;font-size: x-large;font-family:Georgia, Times, 'Times New Roman', serif;width:60%;float:left;">
          <h4> <span style="border :3px solid rgb(51, 47, 47);border-radius:5px;background-color:rgb(51, 47, 47);color:whitesmoke;">
                         <?php if(isset($_SESSION['cname'])){echo $_SESSION['cname'];}?>'s Order </span> </h4>
        </div>
        <div class="view" style="width:20%;float:left;text-align:center;">
        <br>
          <a href="takeorder2.php"> <input type="button" value="Add More" style="width:120px;height:25px; background-color:green;color: whitesmoke;font-size: large;border:1px;border-radius:5px; "> </a>
        </div>
    </div>
    <br><br><br>
    <div style="width:100%">
    <?php
     $_SESSION['totalquantity']=0;
     $_SESSION['grandtotal']=0;
     $_SESSION['totalitems']=0;
                   
                  if(isset($_SESSION['cid'])){
                           $sql1="select * from customer_order where id = '".$_SESSION['cid']."' AND username='".$_SESSION['login']."'"; 
                    
                    $result1=mysqli_query($conn,$sql1);
                    $count=mysqli_num_rows($result1);
                    if($count>0){
                      ?>
                      <div class="table">
                      <?php
                      $i=1;
                      echo "<table>
                      <tr>
                      <th>Sr No.</th>        
                      <th>Item Name</th>
                      <th>Price</th>
                      <th>Quantity</th>
                      <th>Total</th>
                      <th>Remove Item</th>
                      </tr>";     
                      while($row1 = mysqli_fetch_array($result1))
                        {
                          echo "<tr>";
                          echo "<td>" . $i . "</td>";
                          echo "<td>" . ucwords($row1['itemname']) . "</td>"; 
                          echo "<td>Rs.". $row1['price'] . "</td>";
                          echo "<td>" . $row1['itemquantity'] . "</td>";
                          echo "<td>Rs.".  $row1['total']  ."</td>";
                          echo "<td><a href='takeorder3.php?itemname=".$row1['itemname']."' onclick=\"return confirm('Are you sure you want to remove this item?');\" > <button type='button'>".'X'."</button></a></td>";                   
                          echo "</tr>";
                          $_SESSION['totalquantity']= $_SESSION['totalquantity'] + $row1['itemquantity'];
                          $_SESSION['grandtotal']=$_SESSION['grandtotal'] + $row1['total'];
                          $_SESSION['totalitems']=$i;
                          $i++;
                        } 
                        
                      echo "</table>";
                     }
                     else{
                         echo "<br><br><br><br><br>";
                        echo "<h1 style=\"width:100%;float:right;text-align:center;margin-left:-20px;color:rgba(62, 71, 80, 0.83);\"> NO ITEM FOUND IN CART</h1>";
                     }
                    
                    }
                    
                     
         ?>
       </div><br><br>
       <?php
         if($_SESSION['totalquantity'] > 0){
       ?>
       <div style="width:100%">
         <div style="width:25%;float:left;text-align:center">
               <b>Total Quantity : <?php echo $_SESSION['totalquantity'];?></b>
         </div>
         <div style="width:50%;float:left;text-align:center">
               <form method="POST" action="takeorder.php">
                   <input type="submit" value="Place Order" name="placeorder" id="search" onclick="return confirm('Are you sure you want to place this order?');">
               </form>
         </div>
         <div style="width:25%;float:left;text-align:center">

         </div>
             <b>Grand Total : Rs.&nbsp; <?php echo $_SESSION['grandtotal'];?></b>
       </div>
       <br><br><br>
       <?php
         }
         ?>
         <?php
}
else{
  header("location:takeorder.php");
}
?>
</body>
</html>
