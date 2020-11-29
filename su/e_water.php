<?php session_start();?>
<?php
    if($_SESSION["user"]!="admin"){
        header("location: login.php");
    }
?>
<?php
require_once('source/dbconnect.php');
mysqli_set_charset($conn, 'UTF8');

$sql = "SELECT * FROM green_contract t1 INNER JOIN green_room t2 ON t1.room_id = t2.room_id
GROUP BY t1.room_id";
    $result = mysqli_query($conn, $sql);
  
  if (mysqli_num_rows($result) > 0) {
    $rooms = [];
  
    while ($row = mysqli_fetch_assoc($result)) {
      array_push($rooms, $row);
  }
  
  } else {
    echo "0 results";
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>

<?php require_once 'block/block_head.php'?>
<title>Điện Nước</title>
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
  <?php require_once 'block/block_menu.php';  ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">CHỌN PHÒNG</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
          </div>

          <!-- Content Row -->
          <div class="row">
            <?php 
              foreach($rooms as $room){
                
            ?>
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><i class="fa fa-bed"></i></div>
                    </div>
                    <div class="col mr-2">
                      <div class="h5 mb-0 font-weight-bold text-gray-800">PHÒNG <?php echo $room['room_name'] ?></div>
                          <?php 
                            if($room['room_status']==1){
                              $id=$room['contract_id'];
                              echo "<a class='badge badge-primary' href='input_num_new.php?id=$id'>Nhập chỉ số</a>";
                            }
                            else echo "<span class='badge badge-success'>Phòng trống</span>";
                          ?>    
                      </div>
                  </div>
                </div>
              </div>
            </div>
            <?php 
              }
            ?>

          </div>

          <!-- Content Row -->

           
      <!-- End of Main Content -->

      <!-- Footer -->
     
      <?php require_once 'block/block_footer.php'; ?>
 <?php require_once 'block/block_foottag.php'; ?>
</body>

</html>
