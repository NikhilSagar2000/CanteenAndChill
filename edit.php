<?php include 'connection.php';
session_start();
if(isset($_SESSION['login'])){
?>
<?php
  $itemname="";
  $query="";
  $data=array();
   if(isset($_GET['itemname'])){
     $itemname=$_GET['itemname'];
     $query="select * from menu where itemname='$itemname' AND username='".$_SESSION['login']."'";
     $result_update=mysqli_query($conn,$query);
     $data=mysqli_fetch_array($result_update);
   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canteen&Chill</title>
    <link rel="stylesheet" type="text/css" href="css/edit.css">
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
           <a href="edit.php" id="selected"><b>Edit Items</b></a>
           <a href="takeorder.php"><b>Take orders</b></a>
           <a href="totalsales.php"><b>Total Sales</b></a>
       </div>
    </div>
    <script>
       function show(){
         confirm("Are you sure you want to edit this item?");
       }
    </script>
    <div class="edit">
        <div class="selectitem">
               <div class="head">
                       <h1><span style="border :3px solid rgb(51, 47, 47);border-radius:5px;background-color:rgb(51, 47, 47);color:whitesmoke;">
                         Search Item  </span></h1>
               </div>
          <div class="search">
            <form action="" method="POST" autocomplete="off">
            <label for="searchby"><b> Search By :- </b></label>
            <select name="searchby" required >
              <option value="">None</option>
              <option value="all" <?php if (isset($_POST['searchby']) && $_POST['searchby'] == 'all') {echo ' selected="selected"';} ?>>All</option>
              <option value="item">Item Name</option>
              <option value="type">Type</option>
            </select>&nbsp;&nbsp;&nbsp;&nbsp;
            <label for="vsearch"><b>Value :- </b></label>
               <input type="text" id="bar" name="vsearch" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               <br><br><input type="submit" value="Search" id="submit" name="removesub"><br><br>
            </form>
            <?php 
              $count=0;
              if(isset($_POST['removesub'])){
                  if($_POST['searchby']=='item'){
                    $value=$_POST['vsearch'];
                    $search=$_POST['searchby'];
                    $sql="select * from menu where itemname LIKE '%".$value."%' AND username='".$_SESSION['login']."'";
                  }else if($_POST['searchby']=='type'){
                    $value=$_POST['vsearch'];
                    $sql="select * from menu where type LIKE '%".$value."%' AND username='".$_SESSION['login']."'";
                  }else if($_POST['searchby']=='all'){
                    $sql="select * from menu where username='".$_SESSION['login']."'";
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
                  <th>Quantity</th>
                  <th>Edit</th>
                  </tr>";
                  $i=1;      
                  while($row = mysqli_fetch_array($result))
                    {
                  
                        echo "<tr>";
                        echo "<td>" . ucwords($row['itemname']) . "</td>"; 
                        echo "<td>" . ucwords($row['type']) . "</td>";
                        echo "<td>Rs.&nbsp;&nbsp;" .  $row['price'] . "</td>";
                        echo "<td>" .  $row['quantity'] . "</td>";
                        echo "<td><a href='edit.php?itemname=".$row['itemname']."' style=\"text-decoration:none;color:rgb(82, 75, 75);\"> <button type='button'>".'EDIT'."</button></a></td>";          
                        echo "</tr>";
                      }
                      echo "</table>";
                    }    
                    else{
                      echo "<h1 style=\"width:100%;text-align:center;margin-left:-20px;color:rgba(62, 71, 80, 0.83);\"> NO DATA FOUND</h1>";
                    }
                    ?>
                </div>
            </div>
         </div>
        <div class="edititem">
               <div class="head">
                       <h1><span style="border :3px solid rgb(51, 47, 47);border-radius:5px;background-color:rgb(51, 47, 47);color:whitesmoke;">
                         Edit Items  </span></h1>
               </div>
               <div class="form">
                   <form action="" method="POST" autocomplete="off" >
                     <label for="iname" style="margin-left:-110px;"><b>Item Name</b></label><br>
                     <input type="text" name="itemname"  value="<?php if(isset($data['itemname'])){echo $data['itemname'];}?>" required>
                     <br><br>
                     <label for="type" style="margin-left:-120px;"><b>Item type</b></label><br>
                     <input type="text" name="type" value="<?php if(isset($data['type'])){echo $data['type'];}?>" required><br><br>
                     <label for="price" style="margin-left:-155px;"><b>Price</b></label><br>
                     <input type="number" name="price" value="<?php if(isset($data['price'])){echo $data['price'];}?>" required><br><br>
                     <label for="quantity" style="margin-left:-130px;"><b>Quantity</b></label><br>
                     <input type="number" name="quantity" value="<?php if(isset($data['quantity'])){echo $data['quantity'];}?>" required><br><br><br>
                     <input type="submit" value="Edit" id="submit" name="editsub" onclick="show();"><br><br>
                    </form>
                    <?php
                     $iname="";
                       if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['editsub']))
                       {
                         
                         if(isset($data)){
                          $iname=$data['itemname'];
                          $type=$data['type'];
                          $price=$data['price'];
                          $quantity=$data['quantity'];
                         }
                          $niname=$_POST['itemname'];
                          $ntype=$_POST['type'];
                          $nprice=$_POST['price'];
                          $nquantity=$_POST['quantity'];
                          $sql1="update menu SET itemname='$niname',type='$ntype',price=$nprice,quantity=$nquantity WHERE itemname='$iname' AND username='".$_SESSION['login']."'";
                          if($nquantity<1){
                            echo "<i style=\"color:red;\"> Quantity cannot be less than 1</i>";
                          }
                          else if($nprice<1){
                            echo "<i style=\"color:red;\"> Please enter a valid price for the item</i>";
                          }
                          else if(mysqli_query($conn,$sql1)){
                            echo "<i style=\"color:green;\"> Item edited Successfully</i>";
                          }
                          else{
                            echo "<i style=\"color:red;\"> Error Occured</i>";
                          }
                          ?> <script type='text/javascript'>

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

        </div>
    </div>
    <?php
}
else{
    header("location:login.php");
}
?>
