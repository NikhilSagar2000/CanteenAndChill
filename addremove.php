<?php include 'connection.php';
session_start();
if(isset($_SESSION['login'])){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canteen&Chill</title>
    <link rel="stylesheet" type="text/css" href="css/addremove.css">
</head>

<body>
    <div class="header">
        <div class="logo">
        <a href="home.php"> <img src="images/logoname.JPG"></a>
        </div>
    </div>
    <div class="topnav">
       <div class="tabs">
           <a href="home.php" ><b>Home</b></a>
           <a href="#" id="selected"><b>Add/Remove Items</b></a>
           <a href="edit.php"><b>Edit Items</b></a>
           <a href="takeorder.php"><b>Take orders</b></a>
           <a href="totalsales.php"><b>Total Sales</b></a>
       </div>
    </div><br>
    <div class="addremove">
        <div class="add">
               <div class="head">
                       <h1><span style="border :3px solid rgb(51, 47, 47);border-radius:5px;background-color:rgb(51, 47, 47);color:whitesmoke;">
                         Add Items  </span></h1>
               </div>
               <div class="form">
                   <form action="" method="POST" autocomplete="off" >
                     <label for="iname" style="margin-left:-110px;"><b>Item Name</b></label><br>
                     <input type="text" name="iname"  value="<?php if(isset($_POST['iname'])){echo $_POST['iname'];} ?>" required>
                     <br><br>
                     <label for="type" style="margin-left:-120px;"><b>Item type</b></label><br>
                     <input type="text" name="type" value="<?php if(isset($_POST['type'])){echo $_POST['type'];} ?>" required><br><br>
                     <label for="price" style="margin-left:-155px;"><b>Price</b></label><br>
                     <input type="number" name="price" value="<?php if(isset($_POST['price'])){echo $_POST['price'];} ?>" required><br><br>
                     <label for="quantity" style="margin-left:-130px;"><b>Quantity</b></label><br>
                     <input type="number" name="quantity" value="<?php if(isset($_POST['quantity'])){echo $_POST['quantity'];} ?>" required><br><br><br>
                     <input type="submit" value="ADD" id="submit" name="addsub" onclick="return confirm('Are you sure you want to add this item?');" ><br><br>
                    </form>
                    <?php
                       if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['addsub']))
                       {
                          $iname=$_POST['iname'];
                          $type=$_POST['type'];
                          $price=$_POST['price'];
                          $quantity=$_POST['quantity'];
                          $sql1="insert INTO menu(username,itemname,type,price,quantity) VALUES('".$_SESSION['login']."','$iname','$type','$price','$quantity')";
                          if($quantity<1){
                            echo "<i style=\"color:red;\"> Quantity cannot be less than 1</i>";
                          }
                          else if($price<1){
                            echo "<i style=\"color:red;\"> Please enter a valid price for the item</i>";
                          }
                          else if(mysqli_query($conn,$sql1)){
                            echo "<i style=\"color:green;\"> Item Added Successfully</i>";
                          }
                          else{
                            echo "<i style=\"color:red;\"> Item already exists</i>";
                          }
                        }                   
                    ?>
                </div>
        </div>
        <div class="remove">
               <div class="head">
                       <h1><span style="border :3px solid rgb(51, 47, 47);border-radius:5px;background-color:rgb(51, 47, 47);color:whitesmoke;">
                         Remove Items  </span></h1>
               </div>
          <div class="search">
            <form action="" method="POST" autocomplete="off">
            <label for="searchby"><b> Search By :- </b></label>
            <select name="searchby" required >
              <option value="">None</option>
              <option value="item">Item Name</option>
              <option value="type">Type</option>
            </select>&nbsp;&nbsp;&nbsp;&nbsp;
            <label for="vsearch"><b>Value :- </b></label>
               <input type="text" id="bar" name="vsearch" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               <br><br><input type="submit" value="Search" id="submit" name="removesub"><br><br>
            </form>
            <?php 
              $count="";
              if(isset($_POST['removesub'])){
                  if($_POST['searchby']=='item'){
                    $value=$_POST['vsearch'];
                    $search=$_POST['searchby'];
                    $sql="select * from menu where itemname LIKE '%".$value."%' AND username='".$_SESSION['login']."'";
                  }else if($_POST['searchby']=='type'){
                    $value=$_POST['vsearch'];
                    $sql="select * from menu where type LIKE '%".$value."%' AND username='".$_SESSION['login']."'";
                  }else{
                    $sql="select * from menu where username='".$_SESSION['login']."'";
                  }
                  $result=mysqli_query($conn,$sql);
                  $count=mysqli_num_rows($result);
              }
              else{
                  $sql="select * from menu where username='".$_SESSION['login']."'";
                  $result=mysqli_query($conn,$sql);
                  $count=mysqli_num_rows($result);
              }
                if ($count>0)
                {
                 ?>
                <div class="table"> 
                <?php       
                  echo "<table>
                  <tr>        
                  <th>Item Name</th>
                  <th>Type</th>
                  <th>Price</th>
                  <th>Delete</th>
                  </tr>";     
                  while($row = mysqli_fetch_array($result))
                    {
                      echo "<tr>";
                      echo "<td>" . ucwords($row['itemname']) . "</td>"; 
                      echo "<td>" . ucwords($row['type']) . "</td>";
                      echo "<td>Rs.&nbsp;&nbsp;" .  $row['price'] . "</td>";
                      echo "<td><a href='addremove.php?itemname=".$row['itemname']."' onclick=\"return confirm('Are you sure you want to delete this item?');\" style=\"text-decoration:none;color:rgb(82, 75, 75);\"> <button type='button'>".'X'."</button></a></td>";          
                      echo "</tr>";
                    }
                  
                  echo "</table>";
                  echo "<br><br><br>";
            }    
            else{
                   echo "";          
            }
          
            ?>
         
          </div>  
        <?php
                  if(isset($_GET['itemname'])){
                    $itemname=$_GET['itemname'];
                    $del="delete from menu where itemname = '".$itemname."' AND username='".$_SESSION['login']."'";
                    mysqli_query($conn,$del);
          ?>
        
        <script type='text/javascript'>

        (function()
        {
          if( window.localStorage )
          {
            if( !localStorage.getItem('firstLoad') )
            {
              localStorage['firstLoad'] = true;
              window.location.reload();
            }  
            else
              localStorage.removeItem('firstLoad');
          }
        })();
        
        </script> 
        <?php
                  }
        ?>
        </div>
    </div>
    <?php
}
else{
    header("location:login.php");
}
?>

</body>
</html>