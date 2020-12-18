<?php session_start();?>
<?php
    if($_SESSION["user"]!="admin"){
        header("location: login.php");
    }
?>
<?php
  require_once('source/dbconnect.php');
  mysqli_set_charset($conn, 'UTF8');
  $id = $_GET['id'];
  $sql = "SELECT * FROM green_bill t1 INNER JOIN green_bill_items t2 ON t1.bill_id = t2.bill_id
                                      WHERE t1.bill_id = '$id'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
      $bills = [];
    
      while ($row = mysqli_fetch_assoc($result)) {
        array_push($bills, $row);
    }
    
    } else {
      echo "";
    }
  ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
    <link href="css/print.css" rel="stylesheet">
    <title>Hóa Đơn</title>
</head>
<body onload="window.print();">
<div id="page" class="page">
    <div class="header">
        <div class="logo"><img src="img/favicon.ico"/></div>
        <div class="company">Green Light</div>
    </div>
  <br/>
  <div class="title">
        HÓA ĐƠN THANH TOÁN
        <br/>
        -------oOo-------
  </div>
  <br/>
  <br/>
  <table class="TableData">
    <tr>
      <th>STT</th>
      <th>Các loại phí</th>
      <th>Đơn giá</th>
      <th>Số lượng</th>
      <th>Thành tiền</th>
    </tr>
    <?php
      if(empty($bills)){
        echo "<center><h3>Chưa tạo hóa đơn</h3></center>";
      } 
      else{
          $i = 1;
          $a=0;
          foreach($bills as $bill){
              $a += $bill['quantity']*$bill['price'];
      ?>
      <tr>
        <td><center><?php echo $i;?></center></td>
        <td><?php echo $bill['item_name']?></td>
        <td><?php echo number_format($bill['price'])?> đ</td>
        <td><?php echo $bill['quantity']?></td>
        <td><?php echo number_format($bill['quantity']*$bill['price'])?></td>
      </tr>
        <?php 
            $i++;
        }
    ?>
    <tr>
      <td colspan="4" class="tong">Tổng cộng</td>
      <td class="cotSo"><?php echo number_format($a)?> VND</td>
    </tr>
  </table>
  <?php 
      }
    $day = date("d");
    $mon = date("m");
    $year = date("Y");
  ?>
  <div class="footer-left">TP.HCM, ngày <?php echo $day?> tháng <?php echo $mon?> năm <?php echo $year?><br/>
    Khách hàng </div>
  <div class="footer-right">TP.HCM, ngày <?php echo $day?> tháng <?php echo $mon?> năm <?php echo $year?><br/>
    Chủ trọ </div>
</div>
</body>