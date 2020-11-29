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
  $sql = "SELECT * FROM green_contract t1 INNER JOIN green_contract_price t2 ON t1.contract_id = t2.contract_id
                                          INNER JOIN green_room t3 ON t1.room_id = t3.room_id
                                          INNER JOIN green_customer t4 ON t1.customer_id = t4.customer_id
                                          WHERE t1.customer_id = '$id' ";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
      $rooms = [];
    
      while ($row = mysqli_fetch_assoc($result)) {
        array_push($rooms, $row);
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
  ?>
  <head>
    <?php require_once 'block/block_head.php'?>
    <title>Hợp Đồng</title>
  </head>
  <style>
    .btn-primary{margin-left:40px;}
  </style>
<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">
    <?php require_once 'block/block_menu.php';  ?>
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
              <h1 class="h3 mb-0 text-gray-800">THÔNG TIN HỢP ĐỒNG</h1><br>
              <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
          </div>
          <!-- Page Heading -->
          <?php 
            if(empty($rooms)){
                echo "<h3>Chưa có dữ liệu</h3>";
            }
            else{
          ?>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Phòng <?php echo $rooms[0]['room_name'];?> - Hợp đồng đã ký</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>STT</th>
                      <th>Các loại phí</th>
                      <th>Đơn giá</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                        $i = 1;
                        foreach($rooms as $room){  
                    ?>
                    <tr>
                      <td><?php echo $i++;?></td>
                      <td>Tiền phòng</td>
                      <td><?php echo number_format($room['room_price'])?> đ</td>
                    </tr>
                    <tr>
                      <td><?php echo $i++;?></td>
                      <td>Tiền điện</td>
                      <td><?php echo number_format($room['price_electric'])?> đ</td>
                    </tr>
                    <tr>
                      <td><?php echo $i++;?></td>
                      <td>Tiền nước</td>
                      <td><?php echo number_format($room['price_water'])?> đ</td>
                    </tr>
                    <tr>
                      <td><?php echo $i++;?></td>
                      <td>Tiền wifi</td>
                      <td><?php echo number_format($room['price_wifi'])?> đ</td>
                    </tr>
                    <tr>
                      <td><?php echo $i++;?></td>
                      <td>Tiền cap</td>
                      <td><?php echo number_format($room['price_cap'])?> đ</td>
                    </tr>
                      <?php 
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
