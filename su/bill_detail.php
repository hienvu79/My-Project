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
                                      LEFT JOIN green_bill_log t3 ON t1.bill_id = t3.bill_id
                                      WHERE t1.bill_id = '$id'
                                      ORDER BY t2.item_id";
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
  <?php 
  include ("source/class.php");
  $p = new csdl();
  $q = new contract();
  ?>
  <head>
    <?php require_once 'block/block_head.php'?>
    <title>Hóa Đơn</title>
  </head>
  <style>
    .btn-primary{margin-left:40px;}
  </style>
<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

  <?php require_once 'block/block_menu.php';  ?>
    <!-- End of Sidebar -->
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">HÓA ĐƠN THÁNG</h1>
            <a href="print.php?id=<?php if(!empty($bills)){echo $bills[0]['bill_id'];}else echo"";?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> In hóa đơn</a>
          </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Hoá Đơn Tháng <?php $today = date("m/Y"); echo $today;?> - Ngày Thu <?php 
              if(empty($bills)){
                echo "chưa tạo";
              }
              else{
              $date = date("d/m/Y", strtotime($bills[0]['bill_date']));
              echo $date;}?></h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                  <thead>
                      <?php 
                      if(empty($bills)){ 
                        echo "<tr><h3>Chưa tạo hóa đơn phòng này.</h3></tr><br>";
                    }else{ 
                      ?>
                    <tr>
                      <th>STT</th>
                      <th>Các loại phí</th>
                      <th>Đơn giá</th>
                      <th>Số lượng</th>
                      <th>Tổng</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                        $i = 1;
                        foreach($bills as $bill){  
                            $_SESSION['bill_id'] = $bill['bill_id'];
                            
                            $a = $bill['quantity']*$bill['price'];
                    ?>
                    <tr>
                      <td><?php echo $i;?></td>
                      <td><?php echo $bill['item_name']?></td>
                      <td><?php echo number_format($bill['price'])?> đ</td>
                      <td><?php echo $bill['quantity']?></td>
                      <td><?php echo number_format($a)?></td>
                    </tr>
                      <?php 
                          $i++;
                        }
                      }
                  ?>
                  </tbody>
                </table>
                <?php 
                if(empty($bills)){ 
                  echo "";
                }else{ 
                ?>
                <h3><center>Tổng tiền: <?php
                $sum = 0;
                foreach($bills as $bill => $values) { 
                    $price[] = $values['price']; 
                    $quantity[] = $values['quantity']; 
                    $sum= $values['price']*$values['quantity'];
                    $total[] = $sum;
                } 
                
                $Total = array_sum($total); 
                echo number_format($Total);
                ?> đ</center></h3>
                <?php 
                  if($bills['0']['log_status'] == "0"){
                    ?>
                <center><h5>Click vào nút bên dưới nếu hóa đơn đã thu.</h5>
                <form>
                  <button class="btn btn-primary" formmethod="post" name="oke" type="submit" value="<?php echo $bills[0]['bill_id']?>">Đã Thu</button>
                </form></center>
                <?php 
                  }
                  else echo"<center><h3>Hóa đơn đã thu.</h3></center>";
                }?>
                <?php 
                if(!empty($bill)){
                  $bill_id = $bills[0]['bill_id'];
                  if(isset($_POST['oke'])&&isset($bill_id)){
                    {  
                      $con=$p->connect();
                      $q->dathu($bill_id,$con);
                    }   
                  }
                }
                else echo"";
                  ?>   
              </div>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->
      <!-- Footer -->
    <?php require_once 'block/block_footer.php'; ?>
 <?php require_once 'block/block_foottag.php'; ?>

</body>

</html>
