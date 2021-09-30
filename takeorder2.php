<?php
include 'connection.php';
session_start();
if(isset($_SESSION['cid']) && isset($_SESSION['cname']) && isset($_SESSION['cphone'])){
?>
<?php
   $typedata=array();
   $sql1="select * from menu where username='".$_SESSION['login']."'";
   $result1=mysqli_query($conn,$sql1);
   $row1=mysqli_fetch_array($result1);
   while( $row1=mysqli_fetch_array($result1)){
       array_push($typedata,$row1['type']);
       $typedata=array_unique($typedata);
   }
?>
<?php
if(isset($_POST['cancelorder'])){
  $addquery="select * from customer_order where id=".$_SESSION['cid']." AND username ='".$_SESSION['login']."'";
 
  $addresult=mysqli_query($conn,$addquery);
  while($addrow = mysqli_fetch_array($addresult)){
    $addquantity=(int)$addrow['itemquantity'];
    $addquery2="update menu SET quantity = quantity + ".$addquantity." where itemname='".$addrow['itemname']."' AND username='".$_SESSION['login']."'";
    mysqli_query($conn,$addquery2);
  }
  
  $cancel="delete from customer_order where id = ".$_SESSION['cid']." AND username ='".$_SESSION['login']."'";
  mysqli_query($conn,$cancel);
  $view="DELETE from customer WHERE customer_id = ".$_SESSION['cid']." AND username='".$_SESSION['login']."'";
  mysqli_query($conn,$view);
  unset($_SESSION['cid']);
  unset($_SESSION['cname']);
  unset($_SESSION['cphone']);
  header("location:takeorder.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canteen&Chill</title>
    <link rel="stylesheet" type="text/css" media="all" href="css/takeorders2.css">
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
           <a id="selected"><b>Take orders</b></a>
           <a onclick="alert('Please complete your order first or cancel your order to move to this page.');"><b>Total Sales</b></a>
       </div>
    </div><br>
    <div class="details">
        <div class="head">
          <h1> <span style="border :3px solid rgb(51, 47, 47);border-radius:5px;background-color:rgb(51, 47, 47);color:whitesmoke;">
                         Choose Order </span> </h1>
        </div>
        <div class="cdetails">
          <div style="width:25%;float:left"> <b>Order Id :- <?php echo $_SESSION['cid']?></b>  </div>
          <div style="width:25%;float:left"><b>Name :- <?php echo $_SESSION['cname']?></b> </div>
          <div style="width:25%;float:left"><b>PhoneNo. :- <?php echo $_SESSION['cphone']?></b>  </div>     
          <div style="width:25%;float:left"><b>Date :- <?php echo date("d/m/Y")?></b>  </div>     
        </div> <br><br><br>
  </div>
     <div class="three">
        <div class=cancel style="width:20%;float:left;text-align:center">
             <form method="POST" action="">
              <input type="submit" value="Cancel Order" name="cancelorder" onclick="return confirm('Are you sure you want to cancel this order?');" style="width:120px;height:25px; background-color:red;color: whitesmoke;font-size: large;border:1px;border-radius:5px;">
             </form>
        </div>
        <div class="choose" style="width:60%;float:left;text-align:center;"> 
            <form action="" method="POST">
             <label for="searchby" style="  font-size: x-large;"> Search By Type :- </label>
             <select name="searchby" style=" height:27px;background-color: rgb(77, 70, 70);color:  whitesmoke;border-radius: 5px;">
              <option value="all" selected="selected">--Select Type--</option>
               <?php foreach($typedata as $item){
               echo "<option value=\"$item\">$item</option>";
               }
               ?>
            </select> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="submit" value="Search" id="search" name="search"><br><br>
        </form>
        
      </div>
        <div class="view" style="width:20%;float:left;text-align:center;">
       <a href="takeorder3.php"> <input type="button" value="View Order" style="width:120px;height:25px; background-color:green;color: whitesmoke;font-size: large;border:1px;border-radius:5px; "> </a>
      </div>
              </div>
    
                 <?php
                   
                 if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['search'])){            
                     if(isset($_POST['searchby'])){
                         $sql2="select * from menu where type = '".$_POST['searchby']."' AND username='".$_SESSION['login']."'"; 
                     }
                  }
                  else{
                      $sql2="select * from menu where username='".$_SESSION['login']."'";
                  }
                  
                  $result2=mysqli_query($conn,$sql2);
                  $count=mysqli_num_rows($result2);
                  if($count>0){
                    ?>
                    <div class="table">
                    <?php
                    echo "<table>
                    <tr>        
                    <th>Item Name</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Add To Cart</th>
                    </tr>";     
                    while($row2 = mysqli_fetch_array($result2))
                      {
                        echo "<tr>";
                        echo "<td>" . ucwords($row2['itemname']) . "</td>"; 
                        echo "<td>" . ucwords($row2['type']) . "</td>";
                        echo "<td>" .  $row2['price'] . "</td>";
                        echo "<td><input class='quantity".str_replace(' ', '_', $row2['itemname'])."' type='number' onKeyDown='return false;' name='quantity' min='1' max='".$row2['quantity']."' value='1' style='width:50px;' /></td>";
                        echo "<td  style='font-weight:900;font-size:18px;'><a class='href".str_replace(' ', '_', $row2['itemname'])."' href='addtocart.php?itemname=".$row2['itemname']."&price=".$row2['price']."&type=".$row2['type']."' onclick='changehref(".'"'.str_replace(' ', '_', $row2['itemname']).'"'.")' style='text-decoration:none;color:black;'> + </a><td>";          
                        echo "</tr>";
                      } 
                    echo "</table>";
                   } 
                  
                   
             ?>
             </div>
          </div>
        </div>
                </body>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script>

                  function changehref(unique){
                    var res=confirm('Are you sure you want to add this item in cart?');
                    if(res==true){
                    var quantity = $(".quantity"+unique).val() ;
                    var oldUrl = $(".href"+unique).attr("href");
                    var newUrl = oldUrl+'&quantity='+quantity;
                    $(".href"+unique).attr("href", newUrl);
                    }
                    else{
                      window.location.href="takeorder2.php";
                    }

                  }
                </script>
<?php
  }
  else{
    header("location:takeorder.php");
  }
  ?>
</body>
</html>