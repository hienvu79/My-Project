<?php session_start();?>
<?php
	if(!$_SESSION['user'])
	{
		header("location:login.php");
	}
?>
<?php
  require_once 'source/dbconnect.php';
  mysqli_set_charset($conn, 'UTF8'); 
  $id = $_GET['room_id'];
  $cus_id = $_SESSION['customer_id'];
  $sql = "SELECT *
  FROM green_room,green_customer
  WHERE room_id = '$id' AND customer_id = '$cus_id';";
  $result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  $rooms = [];

  while ($row = mysqli_fetch_assoc($result)) {
    array_push($rooms, $row);
}

} else {
  echo "0 results";
}
mysqli_close($conn);
?>
<!doctype html>
<html class="no-js" lang="zxx">
    <head>
        <title>Đặt Lịch Hẹn</title>
        <?php require_once 'block/block_head.php';?>
   </head>
   <style>
    .badge-success{font-size:18px;}
   </style>
   <body>
       
    <!-- Preloader Start -->
    <!-- <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <strong>Hotel</b>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Preloader Start -->

    <header>
       <?php require_once 'block/block_menu.php';?>
    </header>
    <main>
    <!-- slider Area Start-->
        <div class="slider-area">
            <div class="single-slider hero-overly slider-height2 d-flex align-items-center" data-background="assets/img/hero/roomspage_hero.jpg" >
                <div class="container">
                    <div class="row ">
                        <div class="col-md-11 offset-xl-1 offset-lg-1 offset-md-1">
                            <div class="hero-caption">
                                <span>Green Light</span>
                                <h2>Đặt Lịch Hẹn</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        <section class="room-area r-padding1">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-6 col-md-6">
                    <?php
                        foreach($rooms as $room){
                    ?>
                            <div class="single-room mb-50">
                                <div class="room-img">
                                <a href="room.php?id=<?php echo $room['room_id']?>"><img src="upload/room1.jpg" alt=""></a>
                                </div>
                                <div class="room-caption">
                                    <form method="post">
                                        <div class="col-md-12">
                                        <h2>Đặt Lịch Hẹn</h2>
                                        <span class="badge badge-success">Phòng <?php echo $room['room_name']?></span>
                                            <div class="form-group">
                                                <label for="user-name" class="col-form-label">Khách hàng:</label>
                                                <input type="text" class="form-control" name="name" value="<?php echo $room['customer_name']?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="user-pass" class="col-form-label">Chọn ngày:</label>
                                                <input type="date" class="form-control" name="date" id="day" onblur="kiemtrangay();">
                                                <span id="tbdate" class="text-danger">(*)</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="user-pass" class="col-form-label">Chọn giờ:</label>
                                                <input type="time" class="form-control" name="time">
                                            </div>
                                            <div class="form-group">
                                                <label for="user-pass" class="col-form-label">Số điện thoại:</label>
                                                <input type="text" class="form-control" name="sdt" value="<?php echo $room['customer_phone']?>">
                                            </div>
                                            <button class="btn btn-primary" id="demo" formmethod="post" type="submit" name="datlich">Đặt Lịch</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                </div>
            </div>
        </section>
        <?php
            if(isset($_POST['datlich'])){
                $con=$p->connect();
                $date=$_POST['date'];
                $time=$_POST['time'];
                $cus_id=$room['customer_id'];
                $room_id=$id;
                $e->checkdatlich($date,$time,$cus_id,$room_id,$con);
            }
        ?>
        <!-- Gallery img Start-->
        <div class="gallery-area fix">
            <div class="container-fluid p-0">
                <div class="row">
                    <div class="col-md-12">
                        <div class="gallery-active owl-carousel">
                            <div class="gallery-img">
                                <a href="#"><img src="assets/img/gallery/gallery1.jpg" alt=""></a>
                            </div>
                            <div class="gallery-img">
                                <a href="#"><img src="assets/img/gallery/gallery2.jpg" alt=""></a>
                            </div>
                            <div class="gallery-img">
                                <a href="#"><img src="assets/img/gallery/gallery3.jpg" alt=""></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Gallery img End-->
      
    </main>
    <script>
    $(document).ready(function(){
        /*timeline(document.querySelectorAll('.timeline'), {
            mode: 'horizontal',
            visibleItems: 4,
            forceVerticalWidth: 800
        });*/
        //jQuery('.timeline').timeline();
        jQuery('.timeline').timeline({
            mode: 'horizontal',
            visibleItems: 4,
            //forceVerticalWidth: 300
        });
    });
    </script>
    <script>
            function kiemtrangay(){
                var today = new Date();
                today.setDate(today.getDate() + 1);
                var day = document.getElementById("day").value;
                var tbdate = document.getElementById("tbdate");
                if(day < today)
                {
                    tbdate.innerHTML = "loi";
                    return false;
                }
                tbdate.innerHTML = "";
                return true;
            }
        </script>
   <footer>
        <?php require_once 'block/block_footer.php'?> 
   </footer>
   <?php require_once 'block/block_foottag.php'?> 
    </body>
</html>