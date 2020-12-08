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
                                          INNER JOIN green_contract_price t3 ON t1.contract_id = t3.contract_id
                                          LEFT JOIN (
                                          SELECT *
                                            FROM green_contract_record
                                            WHERE record_date IN(
                                            SELECT MAX(record_date) 
                                            FROM green_contract_record GROUP BY contract_id)) t4 ON t1.contract_id = t4.contract_id
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
    <title>Hóa Đơn</title>
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
          <h1 class="h3 mb-2 text-gray-800">Tạo Hóa Đơn</h1>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
              Phòng <?php echo $rooms[0]['room_name']?> - Tháng 
              <?php 
              $today = date("m/Y"); echo $today;?></h6>
            </div>
            <div class="card-body">
                <div class="container">
                    <form name="form" method="post">
                        <?php 
                        foreach($rooms as $room){
                        $price_wifi = number_format($room['price_wifi']);    
                        $price_room = number_format($room['room_price']);
                        $price_cap = number_format($room['price_cap']);
                        $price_e = number_format($room['price_electric']);
                        $price_w = number_format($room['price_water']);
                        $num_e = $room['electric_num_new'] - $room['electric_num_old'];
                        $num_w = $room['water_num_new'] - $room['water_num_old'];
                        //$date = date("05-m-Y", strtotime($room['contract_datetime']));
                        $month = strtotime(date("d-m-Y", strtotime($room['contract_datetime'])) . " +1 month");
                        $date = strftime("05-%m-%Y", $month);
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label >Ngày thu:</label>
                                    <input type="text" class="col-sm-3 form-control" value="<?php echo $date;?>" name="date" readonly>
                                </div>
                                <div class="form-group">
                                    <label >Internet:</label>
                                    <input type="text" class="col-sm-3 form-control" placeholder="<?php echo $price_wifi;?>" name="wifi" required>
                                </div>
                                <div class="form-group">
                                    <label >Truyền hình cáp:</label>
                                    <input type="text" class="col-sm-3 form-control" placeholder="<?php echo $price_cap;?>" name="cap" required>
                                </div>
                                <div class="form-group">
                                    <label >Giá phòng:</label>
                                    <input type="text" class="col-sm-3 form-control" value="<?php echo $price_room;?>" name="p_room" readonly>
                                </div>
                                <div class="form-row">
                                    <div class="col-3 form-group">
                                        <label >Điện:</label>
                                    </div>
                                    <div class="col-3 form-group">
                                        <label >Đơn giá:</label>
                                        <input type="text" class="col-sm-6 form-control" value="<?php echo $room['price_electric'];?>" readonly>
                                    </div>
                                    <div class="col-3 form-group">
                                        <label >Số cũ:</label>
                                        <input type="number" class="col-sm-6 form-control" value="<?php echo $room['electric_num_new'];?>" name="e_old" readonly>
                                    </div>
                                    <div class="col-3 form-group">
                                        <label >Số mới:</label>
                                        <input type="number" class="col-sm-6 form-control" name="e_new">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-3 form-group">
                                        <label >Nước:</label>
                                    </div>
                                    <div class="col-3 form-group">
                                        <label >Đơn giá:</label>
                                        <input type="text" class="col-sm-6 form-control" value="<?php echo $room['price_water'];?>" readonly>
                                    </div>
                                    <div class="col-3 form-group">
                                        <label >Số cũ:</label>
                                        <input type="number" class="col-sm-6 form-control" value="<?php echo $room['water_num_new'];?>" name="w_old" readonly>
                                    </div>
                                    <div class="col-3 form-group">
                                        <label >Số mới:</label>
                                        <input type="number" class="col-sm-6 form-control" name="w_new">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Phí khác:</label>
                                    <input type="text" class="col-sm-3 form-control" placeholder="Phí phát sinh" name="incurred">
                                </div>
                                <hr>
                                <center><button type="submit" class="btn btn-primary" name="them">Tạo hóa đơn</button></center>
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

                $wifi=$_POST['wifi'];
                $cap=$_POST['cap'];
                $p_room=$room['room_price'];
                $e_num=$e_new - $e_old;
                $e_price=$room['price_electric'];
                $w_num=$w_new - $w_old;
                $w_price=$room['price_water'];
                $incurred=$_POST['incurred'];
                $date=$_POST['date'];

                if($wifi=='0') $status = 0;
                  else $status = 1;
                if($cap=='0') $status1 = 0;
                  else $status1 = 1;
                if($incurred=='0') $status2 = 0;
                  else $status2 = 1;
                $q->addrecord($id,$e_old,$w_old,$e_new,$w_new,$con);
                $q->addbill($id,$date,$wifi,$cap,$p_room,$e_num,$e_price,$w_num,$w_price,$incurred,$status,$status1,$status2,$con);
            }
        ?>

  <?php require_once 'block/block_footer.php'; ?>
 <?php require_once 'block/block_foottag.php'; ?>

</body>

</html>
