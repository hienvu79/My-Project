<?php session_start();?>
<?php
    if(!isset($_SESSION["user"])){
        header("location: login.php");
    }
?>
  <?php
  require_once('source/dbconnect.php');
  mysqli_set_charset($conn, 'UTF8');
  
  $sql = "SELECT *
          FROM green_contract AS t1 INNER JOIN green_room AS t2 ON t1.room_id = t2.room_id
                                    INNER JOIN green_customer AS t3 ON t1.customer_id = t3.customer_id";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
      $appoints = [];
    
      while ($row = mysqli_fetch_assoc($result)) {
        array_push($appoints, $row);
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
  $e = new appoint();
  ?>
  <head>
    <?php require_once 'block/block_head.php'?>
    <title>Danh Sách Khách Thuê</title>
  </head>
  <style>
    .btn-primary{margin-left:40px;}
  </style>
<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

  <?php require_once 'block/block_menu.php';  ?>
    <!-- End of Sidebar -->
  </div>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Danh sách các khách trọ</h1>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Customers</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Tên khách hàng</th>
                      <th>Phòng</th>
                      <th>Số điện thoại</th>
                      <th>Số CMND</th>
                      <th>Ngày sinh</th>
                      <th>Ngày vào ở</th>
                      <th>Hạn hợp đồng</th>
                    </tr>
                  </thead>
                  
                  <tbody>
                    <?php 
                        if(empty($appoints)){ 
                          echo "<tr><h3>Không có khách.</h3></tr><br>";
                      }else{ 
                        foreach($appoints as $appoint){  
                          $birth = date("d-m-Y", strtotime($appoint['customer_birthday']));
                          $date = date("d-m-Y", strtotime($appoint['contract_datetime']));
                          $expires = date("d-m-Y", strtotime($appoint['contract_expires']));
                    ?>
                    
                    <tr>
                      <td><?php echo $appoint['customer_name']?></td>
                      <td><?php echo $appoint['room_name']?></td>
                      <td><?php echo $appoint['customer_phone']?></td>
                      <td><?php echo $appoint['customer_identity']?></td>
                      <td><?php echo $birth;?></td>
                      <td><?php echo $date;?></td>
                      <td><?php echo $expires;?></td>
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
