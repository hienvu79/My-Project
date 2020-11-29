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
  $sql = "SELECT * FROM green_contract t1 INNER JOIN green_room t2 ON t1.room_id = t2.room_id
                                          LEFT JOIN (
                                          SELECT *
                                            FROM green_contract_record
                                            WHERE record_date IN(
                                            SELECT MAX(record_date) 
                                            FROM green_contract_record GROUP BY contract_id)) t3 ON t1.contract_id = t3.contract_id
                                          WHERE t1.contract_id = '$id'
    ";
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
    <title>Điện Nước</title>
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
          <h1 class="h3 mb-2 text-gray-800">Nhập Chỉ Số Điện Nước</h1>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
              Phòng <?php echo $rooms[0]['room_name']?> - Tháng <?php $today = date("m/Y"); echo $today;?></h6>
            </div>
            <div class="card-body">
                <div class="container">
                    <form class="form-horizontal">
                      <?php 
                      foreach($rooms as $room){?>
                        <div class="row">
                            <div class="col-md-6">
                              <h3>Điện</h3>
                                <div class="form-group">
                                    <label  class="control-label">Số cũ:</label>    
                                    <input type="number" class="form-control" value="<?php echo $room['electric_num_new'];?>" name="e_old" readonly>
                                </div>
                                <div class="form-group">
                                    <label  class="control-label">Số mới:</label>
                                    <input type="number" class="form-control" name="e_new">
                                </div>
                            </div>
                            <div class="col-md-6">
                              <h3>Nước</h3>
                              <div class="form-group">
                                    <label  class="control-label">Số cũ:</label>
                                    <input type="number" class="form-control" value="<?php echo $room['water_num_new'];?>" name="w_old" readonly>
                                </div>
                                <div class="form-group">
                                    <label  class="control-label">Số mới:</label>
                                    <input type="number" class="form-control" name="w_new">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <center><button class="btn btn-primary" formmethod="post" type="submit" name="them">Thêm</button></center>
                            </div>
                        </div>
                        <?php 
                        }
                        ?>
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
                $e_old=$_POST['e_old'];
                $w_old=$_POST['w_old'];
                $e_new=$_POST['e_new'];
                $w_new=$_POST['w_new'];
                $q->addrecord($id,$e_old,$w_old,$e_new,$w_new,$con);
            }
        ?>

  <?php require_once 'block/block_footer.php'; ?>
 <?php require_once 'block/block_foottag.php'; ?>

</body>

</html>
