<?php session_start();?>
<?php
if(!isset($_SESSION["user"])){
    header("location: login.php");
}
?>
  <?php
  require_once('source/dbconnect.php');
  mysqli_set_charset($conn, 'UTF8');
  $id = $_SESSION['customer_id'];
  $sql = "SELECT * FROM green_bill t1 INNER JOIN green_contract t2 ON t1.contract_id = t2.contract_id
          WHERE t2.customer_id = '$id'";
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
    <title>Danh Sách Hóa Đơn</title>
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
            <h1 class="h3 mb-0 text-gray-800">DANH SÁCH HÓA ĐƠN</h1>
          </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
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
                      <th>Tháng</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                        $i = 1;
                        foreach($bills as $bill){  
                            $_SESSION['bill_id'] = $bill['bill_id'];  
                            $date = date("m/Y", strtotime($bill['bill_date']));                          
                    ?>
                    <tr>
                      <td><?php echo $i;?></td>
                      <td><?php echo $date?></td>
                      <td><a href="bill.php?id=<?php echo $bill['bill_id']?>">Xem chi tiết</a></td>
                    </tr>
                      <?php 
                          $i++;
                        }
                      }
                  ?>
                  </tbody>
                </table> 
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
