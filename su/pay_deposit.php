<?php session_start();?>
<?php
    if($_SESSION["user"]!="admin"){
        header("location: login.php");
    }
?>
  <?php
  require_once('source/dbconnect.php');
  mysqli_set_charset($conn, 'UTF8');
  
    $sql = "SELECT *
    FROM green_appointment t1 INNER JOIN green_room t2 ON t1.room_id = t2.room_id
                              INNER JOIN green_customer t3 ON t1.customer_id = t3.customer_id
                              LEFT JOIN (
                              SELECT *
                              FROM green_log
                              WHERE log_date IN(
                              SELECT MAX(log_date) 
                              FROM green_log GROUP BY appoint_id )) t4 ON t1.appoint_id = t4.appoint_id
                              INNER JOIN green_contract t5 ON t1.customer_id = t5.customer_id
                              WHERE t4.log_status = '9'
                              ";
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
  $e = new contract();
  ?>
  <head>
    <?php require_once 'block/block_head.php'?>
    <title>Trả Tiền Cọc</title>
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
          <h1 class="h3 mb-2 text-gray-800">Danh sách phòng cần trả tiền cọc</h1>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Trả Phòng</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Tên khách trọ</th>
                      <th>Số điện thoại</th>
                      <th>Số Phòng</th>
                      <th>Xác nhận đã trả tiền cọc</th>
                    </tr>
                  </thead>
                  
                  <tbody>
                    <?php 
                      if(empty($appoints)){
                        echo "<tr><h3>Không có dữ liệu</h3></tr>";
                      }
                      else{
                        foreach($appoints as $appoint){  
                    ?>
                    <tr>
                      <td><?php echo $appoint['customer_name']?></td>
                      <td><?php echo $appoint['customer_phone']?></td>
                      <td><?php echo $appoint['room_name']?></td>
                      <td><form><button class="btn btn-primary" formmethod="post" name="oke" type="submit" value="<?php echo $appoint['room_id']?>">Oke</button></form></td>
                    </tr>
                      <?php
                        }
                      }
                  ?>
                  </tbody>
                <?php 
                if(!empty($appoint)){
                  $room_id = $appoint['room_id'];
                  $app_id = $appoint['appoint_id'];
                  $con_id = $appoint['contract_id'];
                  if(isset($_POST['oke']) && $cus_id = $appoint['customer_id']){
                    {  
                      $con=$p->connect();
                      $e->tracoc($app_id,$room_id,$con_id,$con);
                    }   
                  }
                }
                else echo"";
                  ?>   
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
