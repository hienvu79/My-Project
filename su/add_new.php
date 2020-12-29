<?php session_start();?>
<?php
    if($_SESSION["user"]!="admin"){
        header("location: login.php");
    }
?>
  <?php
  require_once('source/dbconnect.php');
  mysqli_set_charset($conn, 'UTF8');
  $sql = "SELECT * FROM green_room";
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
    <title>Thêm Khách Trọ</title>
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
          <h1 class="h3 mb-2 text-gray-800"></h1>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Thêm khách trọ</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user-name" class="col-form-label">Tên đăng nhập:</label>
                                    <input type="text" class="form-control" name="user">
                                </div>
                                <div class="form-group">
                                    <label for="user-pass" class="col-form-label">Mật khẩu:</label>
                                    <input type="password" class="form-control" name="pass">
                                </div>
                                <div class="form-group">
                                    <label for="cus-name" class="col-form-label">Họ và tên:</label>
                                    <input type="text" class="form-control" name="fullname">
                                </div>
                                <div class="form-group">
                                    <label for="cus-sdt" class="col-form-label">Số Điện Thoại:</label>
                                    <input  type="text" class="form-control" name="sdt">
                                </div>
                                <div class="form-group">
                                    <label for="cus-room" class="col-form-label">Chọn Phòng:</label>
                                    <select id="select" name="room" class="form-control" onchange="chonid()">
                                    <option value="">Chọn phòng</option>
                                    <?php foreach($rooms as $room){
                                      ?>
                                    <option value="<?php echo $room['room_id']?>"><?php echo $room['room_name']?></option>
                                      <?php }?>
                                  </select>
                              </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cus-cmnd" class="col-form-label">Số CMND/Thẻ căn cước:</label>
                                    <input type="text" class="form-control" name="cmnd">
                                </div>
                                <div class="form-group">
                                    <label for="cus-date" class="col-form-label">Ngày sinh:</label>
                                    <input type="date" class="form-control" name="birthday">
                                </div>
                                <div class="form-group">
                                    <label for="cus-date" class="col-form-label">Ngày vào ở:</label>
                                    <input type="date" class="form-control" name="join">
                                </div>
                                <div class="form-group">
                                    <label for="cus-date" class="col-form-label">Ngày kết thúc:</label>
                                    <input type="date" class="form-control" name="expires">
                                </div>
                                <div class="form-group">
                                  <label class="col-form-label">ID Phòng:</label>
                                  <input type="text" class="form-control" id="room_id" name="room_id" readonly/>   
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
    <script>
      function chonid(){
      var id = document.getElementById("select").value;
      var vt = id.indexOf(";");
      var r_id = id.substring(vt + 1,id.length);
      document.getElementById("room_id").value = r_id;
    }
    </script>
        <?php
            if(isset($_POST['them'])){
                $con=$p->connect();
                $user=$_POST['user'];
                $pass=$_POST['pass'];
                $pass=md5($pass);
                $fullname=$_POST['fullname'];
                $sdt=$_POST['sdt'];
                $cmnd=$_POST['cmnd'];
                $ngaysinh=$_POST['birthday'];
                $join=$_POST['join'];
                $expires=$_POST['expires'];
                $id=$_POST['room_id'];
                $q->checknew($id,$user,$pass,$fullname,$sdt,$cmnd,$ngaysinh,$join,$expires,$con);
            }
        ?>

  <?php require_once 'block/block_footer.php'; ?>
 <?php require_once 'block/block_foottag.php'; ?>

</body>

</html>
