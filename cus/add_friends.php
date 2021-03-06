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
  $sql = "SELECT * FROM green_contract t1 INNER JOIN green_room t2 ON t1.room_id = t2.room_id
          WHERE t1.customer_id = '$id'";
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
  $q = new customer();
  ?>
  <head>
    <?php require_once 'block/block_head.php'?>
    <title>Thêm Bạn Trọ</title>
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
          <h1 class="h3 mb-2 text-gray-800">Thêm bạn trọ</h1>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Phòng <?php if(!empty($rooms)){echo $rooms[0]['room_name'];} else echo"";?></h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <form>
                    <?php 
                          if(!isset($rooms)){
                            echo "<h5>Bạn chưa trở thành khách trọ để thực hiện chức năng này.</h5>";
                          }
                          else{
                          ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cus-name" class="col-form-label">Họ và tên:</label>
                                    <input type="text" class="form-control" name="fullname">
                                </div>
                                <div class="form-group">
                                    <label for="cus-sdt" class="col-form-label">Số Điện Thoại:</label>
                                    <input  type="text" class="form-control" name="sdt">
                                </div>
                                <div class="form-group">
                                    <label for="cus-cmnd" class="col-form-label">Số CMND/Thẻ căn cước:</label>
                                    <input type="text" class="form-control" name="cmnd">
                                </div>
                            </div>
                            <div class="col-md-6">
                                
                                <div class="form-group">
                                    <label for="cus-date" class="col-form-label">Ngày sinh:</label>
                                    <input type="date" class="form-control" name="birthday">
                                </div>
                                <div class="form-group">
                                    <label for="cus-date" class="col-form-label">Ngày vào ở:</label>
                                    <input type="date" class="form-control" name="join">
                                </div>
                                <div class="form-group">
                                    <label for="cus-date" class="col-form-label">Hạn hợp đồng:</label>
                                    <input type="text" class="form-control" name="expires" value="<?php if(!empty($rooms)){echo $rooms[0]['contract_expires'];}else echo"";?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <center><button class="btn btn-primary" formmethod="post" type="submit" name="them">Thêm</button></center>
                            </div>
                        </div>
                        <?php }?>
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
                $fullname=$_POST['fullname'];
                $sdt=$_POST['sdt'];
                $cmnd=$_POST['cmnd'];
                $ngaysinh=$_POST['birthday'];
                $join=$_POST['join'];
                $expires=$_POST['expires'];
                $room_id=$rooms[0]['room_id'];
                $q->checknew($room_id,$fullname,$sdt,$cmnd,$ngaysinh,$join,$expires,$con);
            }
        ?>

  <?php require_once 'block/block_footer.php'; ?>
 <?php require_once 'block/block_foottag.php'; ?>

</body>

</html>
