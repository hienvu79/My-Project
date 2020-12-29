<?php session_start();?>
<?php
    if(!isset($_SESSION["user"])){
        header("location: login.php");
    }
?>
  <?php
  require_once('source/dbconnect.php');
  mysqli_set_charset($conn, 'UTF8');
  $room_id = $_GET['id'];
  $sql = "SELECT * FROM green_contract t1 INNER JOIN green_room t2 ON t1.room_id = t2.room_id
                                          LEFT JOIN green_appointment t3 ON t1.room_id = t3.room_id
   WHERE t1.room_id = '$room_id'";
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
  $q = new contract();
  ?>
  <head>
    <?php require_once 'block/block_head.php'?>
    <title>Nhập Giá Trị Hợp Đồng</title>
  </head>
  <style>
    .btn-primary{margin-left:40px;}
    .col-md-5 button{margin:0 auto;}
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
          <h1 class="h3 mb-2 text-gray-800">Nhập Giá Trị Hợp Đồng</h1>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Hợp đồng số <?php echo $rooms[0]['contract_id'];?></h6>
            </div>
            <div class="card-body">
                <div class="container">
                    <form class="form-horizontal">
                        <div class="row">
                            <div class="col-md-4">
                              <h3>Điện</h3>
                                <div class="form-group">
                                    <label  class="control-label">Số điện hiện tại:</label>
                                    <input type="number" class="form-control" name="e_old">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Đơn giá:(Kwh)</label>
                                    <input type="number" class="form-control" name="e_price">
                                </div>
                            </div>
                            <div class="col-md-4">
                              <h3>Nước</h3>
                              <div class="form-group">
                                    <label  class="control-label">Số nước hiện tại:</label>
                                    <input type="number" class="form-control" name="w_old">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Đơn giá:(m3)</label>
                                    <input type="number" class="form-control" name="w_price">
                                </div>
                            </div>
                            <div class="col-md-4">
                              <h3>Khoản khác</h3>
                                <div class="form-group">
                                  <label class="col-form-label">Internet:</label>
                                  <input type="number" class="form-control" name="wifi">
                                </div>
                                <div class="form-group">
                                  <label class="col-form-label">TH cáp:</label>
                                  <input type="number" class="form-control" name="cap">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <center><button class="btn btn-primary" formmethod="post" type="submit" name="them">Thêm</button></center>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->
      <!-- Footer -->
    
        <?php
            if(isset($_POST['them'])){
                $con=$p->connect();
                $id=$rooms[0]['contract_id'];
                $e_old=$_POST['e_old'];
                $e_price=$_POST['e_price'];
                $w_old=$_POST['w_old'];
                $w_price=$_POST['w_price'];
                $wifi=$_POST['wifi'];
                $cap=$_POST['cap'];
                $app_id=$rooms[0]['appoint_id'];
                $q->checkprice($id,$app_id,$e_old,$e_price,$w_old,$w_price,$wifi,$cap,$con);
            }
        ?>


  <?php require_once 'block/block_footer.php'; ?>
 <?php require_once 'block/block_foottag.php'; ?>

</body>

</html>
