<?php session_start();?>
<?php
    if(!isset($_SESSION["user"])){
        header("location: login.php");
    }
?>
<?php
require_once('source/dbconnect.php');
mysqli_set_charset($conn, 'UTF8');
$id = $_GET['id'];
$sql = "SELECT * FROM green_contract t1 INNER JOIN green_room t2 ON t1.room_id = t2.room_id 
                                        INNER JOIN green_customer t3 ON t1.customer_id = t3.customer_id
        WHERE t1.room_id = '$id'";
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
<title>Thông Tin Phòng</title>
<link rel="stylesheet" href="css/customer.css">
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
  <?php require_once 'block/block_menu.php';  ?>
    <div class="container-fluid">
    <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">THÔNG TIN KHÁCH TRỌ</h1><br>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
              Phòng <?php echo $rooms[0]['room_name']?></h6>
            </div>
          <!-- Content Row -->
        <script src="js/feather.min.js" integrity="sha256-xHkYry2yRjy99N8axsS5UL/xLHghksrFOGKm9HvFZIs=" crossorigin="anonymous"></script>
        <div class="container">
            <div class="row">
            <!-- Start col -->
                <?php 
                    foreach($rooms as $room){
                    $birth = date("d-m-Y", strtotime($room['customer_birthday']));
                    $date = date("d-m-Y", strtotime($room['contract_datetime']));
                    $expires = date("d-m-Y", strtotime($room['contract_expires']));
                ?>
                <div class="col-lg-6">
                    <div class="card m-b-30">  
                        <div class="card-body py-5">
                            <div class="row">
                                <div class="col-lg-3 text-center">
                                    <img src="img/avatar1.jpg" class="img-fluid mb-3" alt="user" />
                                </div>
                                <div class="col-lg-9">
                                    <h4><?php echo $room['customer_name']?></h4>
                                    <div class="button-list mt-4 mb-3">
                                        <?php 
                                            if(empty($room)){
                                             ?>   
                                            <a type="button" class="btn btn-primary-rgba" href="contract.php?id=<?php $con_id = $room['contract_id']; echo $con_id?>">
                                            <i class="feather icon-message-square mr-2"></i>Nhập giá trị hợp đồng</a>
                                            <?php    
                                            }
                                            else echo"";
                                        ?>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-borderless mb-0">
                                            <tbody>
                                                <tr>
                                                    <th scope="row" class="p-1">Số CMND :</th>
                                                    <td class="p-1"><?php echo $room['customer_identity']?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row" class="p-1">Ngày Sinh :</th>
                                                    <td class="p-1"><?php echo $birth;?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row" class="p-1">Số Điện Thoại :</th>
                                                    <td class="p-1"><?php echo $room['customer_phone']?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row" class="p-1">Ngày Thuê Trọ :</th>
                                                    <td class="p-1"><?php echo $date;?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row" class="p-1">Ngày Hết Hạn HĐ:</th>
                                                    <td class="p-1"><?php echo $expires;?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- End col -->
                <?php  
                }    
            ?>
            </div>
        </div>
 
    <?php require_once 'block/block_footer.php'; ?>
    <?php require_once 'block/block_foottag.php'; ?>
</body>

</html>
