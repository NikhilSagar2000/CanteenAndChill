<?php
include 'connection.php';
session_start();
if(isset($_SESSION['login'])){
?>
<?php
 if(isset($_GET['itemname']) && isset($_GET['price']) && isset($_GET['type']) && isset($_GET['quantity'])!=0 ){
   $id=$_SESSION['cid']; 
   $itemname=$_GET['itemname'];
   $price=$_GET['price'];
   $type=$_GET['type'];
   $quantity=$_GET['quantity'];
   $total=$price*$quantity;
   $username=$_SESSION['login'];
   $sql3="insert into customer_order(username,id,itemname,itemtype,price,itemquantity,total,date) VALUES('$username','$id','$itemname','$type','$price','$quantity','$total',CURDATE())";
   $result1=mysqli_query($conn,"select * from menu where itemname='$itemname' and username='".$_SESSION['login']."'");
   $data1=mysqli_fetch_assoc($result1);
   if($data1['quantity']>=$quantity){
      if(mysqli_query($conn,$sql3)){
        mysqli_query($conn,"update menu SET quantity = quantity - ".$quantity." where itemname='".$itemname."' and username='".$username."'");
        header("location: takeorder2.php");
      }
      else{
         $result2=mysqli_query($conn,"select * from customer_order where itemname = '$itemname' and username='".$username."'");
         $data2=mysqli_fetch_assoc($result2);
         if($data1['quantity']>=$quantity){
            $sql4="UPDATE customer_order SET itemquantity = itemquantity + ".$quantity." WHERE id = ".$_SESSION['cid']." AND itemname = '".$itemname."' AND username='".$username."'";
            mysqli_query($conn,$sql4);
            mysqli_query($conn,"update customer_order set total = itemquantity * price WHERE id = ".$_SESSION['cid']." AND itemname = '".$itemname."' AND username='".$username."'");
            mysqli_query($conn,"update menu SET quantity = quantity - ".$quantity." where itemname='".$itemname."' AND username='".$username."'");
            header("location: takeorder2.php");
         }
         else{
           die("ERROR:NOT ENOUGH QUANTITY AVAILABLE");
         }
      }
    }
    else{
      die("ERROR:NOT ENOUGH QUANTITY AVAILABLE");
    }
 }
 else{
   header("location:takeorder2.php");
 }
?>
<?php
}
else{
    header("location:login.php");
}
?>
