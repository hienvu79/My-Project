<?php session_start();?>
<?php
    if($_SESSION["user"]!="admin"){
        header("location: login.php");
    }
?>
  <?php
  require_once('source/dbconnect.php');
  mysqli_set_charset($conn, 'UTF8');
  
  $sql = "SELECT * FROM green_appointment t1 INNER JOIN green_room t2 ON t1.room_id = t2.room_id
                                             INNER JOIN green_customer t3 ON t1.customer_id = t3.customer_id
                                             INNER JOIN green_log t4 ON t1.appoint_id=t4.appoint_id
                                             WHERE t4.log_status='3'";
    
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
      $customers = [];
    
      while ($row = mysqli_fetch_assoc($result)) {
        array_push($customers, $row);
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
          <h1 class="h3 mb-2 text-gray-800">Thêm khách trọ</h1>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Customers</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                      <form>
                        <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="col-form-label">Họ và tên:</label>
                                <select id="select" class="form-control" onChange="chonid();">
                                    <option value="">Chọn khách trọ</option>
                                    <?php foreach($customers as $cus){?>
                                    <option value="<?php echo $cus['customer_id']?>"><?php echo $cus['customer_name']?></option>
                                    <?php }?>
                                  </select>
                              </div>
                              <div class="form-group">
                                <label class="col-form-label">ID khách trọ:</label>
                                <input type="text" class="form-control" id="cus_id" name="cus_id" readonly/>   
                              </div>
                              <div class="form-group">
                                <label class="col-form-label">Số phòng:</label>
                                <select id="select1" class="form-control" onChange="chonphong();">
                                    <option value="">Chọn phòng</option>
                                    <?php foreach($customers as $cus){?>
                                    <option value="<?php echo $cus['room_id']?>"><?php echo $cus['room_name']?></option>
                                    <?php }?>
                                  </select>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                  <label for="cus-date" class="col-form-label">Ngày vào ở:</label>
                                  <input type="date" class="form-control" name="join">
                              </div>
                              <div class="form-group">
                                  <label for="cus-date" class="col-form-label">Ngày kết thúc:</label>
                                  <input type="date" class="form-control" name="expires">
                              </div>
                              <div class="form-group">
                                <label class="col-form-label">ID phòng:</label>
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
    
        <?php
            if(isset($_POST['them'])){
                $con=$p->connect();
                $cus_id=$_POST['cus_id'];
                $room_id=$_POST['room_id'];
                $join=$_POST['join'];
                $expires=$_POST['expires'];
                $q->checkadd($cus_id,$room_id,$join,$expires,$con);
            }
        ?>
  <script>
    function chonid(){
      var id = document.getElementById("select").value;
      var vt = id.indexOf(";");
      var cus_id = id.substring(vt + 1,id.length);
      document.getElementById("cus_id").value = cus_id;
    }
    function chonphong(){
      var r_id = document.getElementById("select1").value;
      var vt = r_id.indexOf(";");
      var room_id = r_id.substring(vt + 1,r_id.length);
      document.getElementById("room_id").value = room_id;
    }
  </script>
  <?php require_once 'block/block_footer.php'; ?>
 <?php require_once 'block/block_foottag.php'; ?>

</body>

</html>
