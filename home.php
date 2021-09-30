<?php include 'connection.php';
session_start();
if(isset($_SESSION['login'])){
?>
<?php
if (isset($_POST['logout'])){
    session_destroy();
    header("location:index.html");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canteen&Chill</title>
    <link rel="stylesheet" type="text/css" href="css/home.css">
</head>
<body>
    <div class="header">
        <div class="logo">
        <a href="home.php"> <img src="images/logoname.JPG"></a>
        </div>
    </div>
    <div class="topnav">
       <div class="tabs">
           <a href="#" id="selected"><b>Home</b></a>
           <a href="addremove.php"><b>Add/Remove Items</b></a>
           <a href="edit.php"><b>Edit Items</b></a>
           <a href="takeorder.php"><b>Take Order</b></a>
           <a href="totalsales.php"><b>Total Sales</b></a>
       </div>
    </div><br><br><br>
    <form action="" method="POST" autocomplete="off">
    <div class="filter">
          <div class="search">
            <label for="searchby"> Search By :- </label>
            <select name="searchby"  required >
              <option value="none" <?php if (isset($_POST['searchby']) && $_POST['searchby'] == 'none') {echo ' selected="selected"';} ?>>None</option>
              <option value="item" <?php if (isset($_POST['searchby']) && $_POST['searchby'] == 'item') {echo ' selected="selected"';} ?> >Item Name</option>
              <option value="type" <?php if (isset($_POST['searchby']) && $_POST['searchby'] == 'type') {echo ' selected="selected"';} ?>>Type</option>
            </select> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <label for="vsearch">Value :- </label>
               <input type="text" id="bar" name="vsearch" value="<?php if(isset($_POST['vsearch'])){echo $_POST['vsearch'];}?>">
            
          </div>   
          <div class="sort">
              <label>Sort By :- </label>
              <select name="sortby" style="width:150px;">
              <option value="none" <?php if (isset($_POST['sortby']) && $_POST['sortby'] == 'none') {echo ' selected="selected"';} ?>>None</option>
              <option value="pricel2h" <?php if (isset($_POST['sortby']) && $_POST['sortby'] == 'pricel2h') {echo ' selected="selected"';} ?>>Price low to high</option>
              <option value="priceh2l" <?php if (isset($_POST['sortby']) && $_POST['sortby'] == 'priceh2l') {echo ' selected="selected"';} ?>>Price high to low</option>
            </select> 
          </div>
          <div class="find">
          <input type="submit" name="submit" value="Search" required style="background-color:rgb(77, 70, 70);width:75px;height:30px;color:white;bAND username=$_SESSION['login']-radius:10px;margin-top:5px;margin-left:-20px;">
          </div>
    </div><br>
    </form>
    <?php 
        if(isset($_POST['submit'])){
            if($_POST['searchby']=='item'){
                $value=$_POST['vsearch'];
                $search=$_POST['searchby'];
               if($_POST['sortby']=='pricel2h') {
                $sql="select * from menu where itemname LIKE '%".$value."%' AND username = '".$_SESSION['login']."' ORDER BY price ASC";
               } else if($_POST['sortby']=='priceh2l') {
                $sql="select * from menu where itemname LIKE '%".$value."%' AND username='".$_SESSION['login']."' ORDER BY price DESC";  
               } else {
                $sql="select * from menu where itemname LIKE '%".$value."%' AND username='".$_SESSION['login']."'";
               }
            }else if($_POST['searchby']=='type'){
                $value=$_POST['vsearch'];
                if($_POST['sortby']=='pricel2h') {
                    $sql="select * from menu where type LIKE '%".$value."%' AND username='".$_SESSION['login']."' ORDER BY price ASC";
                } else if($_POST['sortby']=='priceh2l') {
                    $sql="select * from menu where type LIKE '%".$value."%' AND username='".$_SESSION['login']."' ORDER BY price DESC";
                } else {
                    $sql="select * from menu where type LIKE '%".$value."%' AND username='".$_SESSION['login']."' ORDER BY type";
                }
            }
            else{
                if($_POST['sortby']=='pricel2h') {
                    $sort=$_POST['sortby'];
                   $sql="select * from menu where username='".$_SESSION['login']."' ORDER BY price ASC";
                }
                else if($_POST['sortby']=='priceh2l') {
                    $sort=$_POST['sortby'];
                    $sql="select * from menu where username='".$_SESSION['login']."' ORDER BY price DESC";
                }
                else{
                    $sql="select * from menu where username='".$_SESSION['login']."'"; 
                }
                
            }
        } else {
            $sql="select * from menu where username='".$_SESSION['login']."'";
          }
        
        $result=mysqli_query($conn,$sql);
        $count=mysqli_num_rows($result);         
    ?>
    
     <br><br><br>
    
    <?php 
        if ($count>0)
        {
    ?>
        <div class="table"> 
        <?php       
          echo "<table>
          <tr>
          <th>S No.</th>         
          <th>Item Name</th>
          <th>Type</th>
          <th>Price</th>
          <th>Quantity</th>
          </tr>";
          $i=1;      
          while($row = mysqli_fetch_array($result))
            {
              echo "<tr>";
              echo "<td>" . $i . "</td>";
              $i++;
              echo "<td>" . ucwords($row['itemname']) . "</td>"; 
              echo "<td>" . ucwords($row['type']) . "</td>";
              echo "<td>Rs.&nbsp;&nbsp;".  $row['price'] . "</td>";
              echo "<td>" . $row['quantity'] . "</td>";          
              echo "</tr>";
            }
          echo "</table>";
    }    
    else{
        echo "<img class=\"oops\" src=\"images/nodata.png\" width =\"350px\" style=\"margin-left: 50%;transform: translateX(-50%)\">";
        echo "<h1 style=\"width:100%;text-align:center;color:rgba(62, 71, 80, 0.83);\"> NO DATA FOUND</h1>";
    }

  ?>
    </div>
    <br><br><br>
    <div style="width:100%;text-align:center;">
    <form action="" method="POST">
        <input type="submit" name="logout" value="LOGOUT" id="search" onclick="return confirm('Are you sure you want to logout?')">
    </form>
    <br><br>
</div>
<?php
}
else{
    header("location:login.php");
}
?>


</body>
</html>    

    
    