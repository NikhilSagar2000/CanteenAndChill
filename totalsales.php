<?php
include 'connection.php';
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
                         Total Sales </span> </h1>
        </div> 
        <div style="width:100%;text-align:center">
            <form action="" method="POST">
                 <label for="dates" style="  font-size: x-large;">Date :- </label>&nbsp;&nbsp;
                 <input type="date" name="dates" value="<?php echo $_POST['dates'];?>">&nbsp;&nbsp;&nbsp;&nbsp;
                 <input type="submit" name="search" id="search" value="Search" >
            </form>
        </div> <br><br>
        <?php
        if(isset($_POST['search'])){
          if(isset($_POST['dates'])){
              $daterec=strtotime($_POST['dates']);
              $date=date('d',$daterec);
              $month=date('m',$daterec);
              $year=date('Y',$daterec);
              $sql="select * from customer where date = '".$year."-".$month."-".$date."' AND username='".$_SESSION['login']."'";
          }
          else{
              $sql="select * from customer where username='".$_SESSION['login']."' order by date desc";
          }
        }
        else{
            $sql="select * from customer where username='".$_SESSION['login']."' order by date desc";
        }
        $result=mysqli_query($conn,$sql);
        $count=mysqli_num_rows($result);
        $_SESSION['totalorders']=0;
        $_SESSION['totalsaleamount']=0;
        if($count>0){
            echo "<table>
            <tr>
            <th>S No.</th>
            <th>Date(yyyy-mm-dd)</th>                   
            <th>Customer ID</th>
            <th>Customer's Name</th>
            <th>Total</th>
            <th>Details</th>
            </tr>";
            $i=1;      
            while($row = mysqli_fetch_array($result))
              {
                echo "<tr>";
                echo "<td>" . $i . "</td>";
                echo "<td>" . $row['date'] . "</td>";
                echo "<td>" .$row['customer_id']. "</td>"; 
                echo "<td>" . ucwords($row['customer_name']) . "</td>";
                echo "<td>Rs.&nbsp;&nbsp;".  $row['total'] . "</td>";
                echo "<td><a href='details.php?customerid=".$row['customer_id']."&customername=".ucwords($row['customer_name'])."' style=\"text-decoration:none;color:rgb(82, 75, 75);\"> <button type='button'>".'DETAILS'."</button></a></td>";                  
                echo "</tr>";
                $_SESSION['totalorders']=$i;
                $_SESSION['totalsaleamount']= $_SESSION['totalsaleamount'] + $row['total'];
                $i++;
             }
            echo "</table>";
            echo "<br><br><br>"
            ?>
            <div style="width:100%;">
                <div style="width:50%;float:left;text-align:center">
                   <h3>Total Orders :- <i style="color:green"><?php echo $_SESSION['totalorders'];?></i></h3>
                </div>
                <div style="width:50%;float:left;text-align:center">
                   <h3>Total Sales :-<i style="color:green"> Rs.&nbsp;&nbsp;<?php echo $_SESSION['totalsaleamount'];?></i></h3>
                </div>
            </div>
           <?php
            }    
            else{
                echo "<br><br><br><br>";
                echo "<img class=\"oops\" src=\"images/nodata.png\" width =\"200px\" >";
                echo "<h1 style=\"width:100%;text-align:center;margin-left:-20px;color:rgba(62, 71, 80, 0.83);\"> NO DATA FOUND</h1>";
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
