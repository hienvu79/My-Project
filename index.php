<?php session_start();?>
<?php ob_start();?>
<?php

require_once('source/dbconnect.php');
mysqli_set_charset($conn, 'UTF8');

$sql = "SELECT  t1.*, MIN(t2.img_id), t2.img_link, t3.*
    FROM green_room AS t1 INNER JOIN green_room_img AS t2 ON t1.room_id = t2.room_id
                          INNER JOIN green_room_zone AS t3 ON t1.zone_id = t3.zone_id
    GROUP BY t1.zone_id";
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

<!doctype html>
<html class="no-js" lang="zxx">
    <head>
        <title>Trang Chủ</title>
        <?php require_once 'block/block_head.php';?>
   </head>
<?php 

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
?>
   <body>
       
    <!-- Preloader Start -->
    <!-- <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <strong>Trang chủ</b>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Preloader Start -->

    <header>
    <?php require_once 'block/block_menu.php'?>

    </header>
    
    <main>

        <!-- slider Area Start-->
        <div class="slider-area ">
            <!-- Mobile Menu -->
            <div class="slider-active dot-style">
                <div class="single-slider  hero-overly slider-height d-flex align-items-center" data-background="assets/img/hero/h1_hero.jpg" >
                    <div class="container">
                        <div class="row justify-content-center text-center">
                            <div class="col-xl-9">
                                <div class="h1-slider-caption">
                                    <h1 data-animation="fadeInUp" data-delay=".4s">top rooms in the city</h1>
                                    <h3 data-animation="fadeInDown" data-delay=".4s">Green's Room</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- slider Area End-->

        <!-- Booking Room Start-->
        <div class="booking-area">
            <div class="container">
                <div class="row ">
                    <div class="col-xl-6">
                        <form action="">
                            <div class="booking-wrap d-flex justify-content-between align-items-center">
                                <!-- Single Select Box -->
                                <div class="single-select-box mb-30">
                                    <div class="boking-tittle">
                                        <span>Tìm Kiếm Theo Khu Vực:</span>
                                    </div>
                                    <div class="select-this">
                                        <form action="#" method="post">
                                            <div class="select-itms">
                                                <select name="zone" id="select1">
                                                    <option value="">Chọn khu vực</option>
                                                    <?php
                                                    foreach($rooms as $room){
                                                    ?>  
                                                        <option value="<?php echo $room['zone_id']?>"><?php echo $room['zone_name']?></option>
                                                        <?php 
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                            </div>
                                <!-- Single Select Box -->
                                <div class="single-select-box pt-45 mb-30">
                                    <button type="submit" formmethod="post" class="btn select-btn" name="timkiem">Tìm Kiếm</button>
                            </div>
                            <?php 
                            
                                if(isset($_POST["timkiem"])) 
                                    { 
                                        if(isset($_POST['zone']))
                                        {
                                            $zone = $_POST['zone'];
                                            header("Location: zone.php?zone=$zone");
                                        }
                                    } 
                            ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Booking Room End-->

        <!-- Room Start -->
        <section class="room-area">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-8">
                        <!--font-back-tittle  -->
                        <div class="font-back-tittle mb-45">
                            <div class="archivment-front">
                                <h3>Danh Sách Phòng</h3>
                            </div>
                            <h3 class="archivment-back">Our Rooms</h3>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <?php
                        foreach($rooms as $room){
                        $num =  $room['room_price'];
                        $format_num = number_format($num);
                     ?>
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <!-- Single Room -->
                        <div class="single-room mb-50">
                            <div class="room-img">
                               <a href="room.php?id=<?php echo $room['room_id']?>"><img src="upload/<?php echo $room['img_link']?>" alt=""></a>
                            </div>
                            <div class="room-caption">
                                <h3><a href="room.php?id=<?php echo $room['room_id']?>">Phòng <?php echo $room['room_name']?></a></h3>
                                <?php 
                                    if($room['room_status']==0) echo "<span class='badge badge-pill badge-success'>Phòng trống</span>";
                                    else echo "<span class='badge badge-pill badge-danger'>Đã cho thuê</span>";
                                ?>
                                <div class="per-night">
                                    <span><?php echo  $format_num?> VND <span>/ 1 tháng</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                </div>                
                <div class="row justify-content-center">
                    <div class="room-btn pt-70">
                        <a href="rooms.php" class="btn view-btn1">Xem Thêm  <i class="ti-angle-right"></i> </a>
                    </div>
                </div>
            </div>

        </section>
        <!-- Room End -->

        <!-- Dining Start -->
        <div class="dining-area dining-padding-top">
            <!-- Single Left img -->
            <div class="single-dining-area left-img">
                <div class="container">
                    <div class="row justify-content-end">
                        <div class="col-lg-8 col-md-8">
                            <div class="dining-caption">
                                <span>Our resturent</span>
                                <h3>Dining & Drinks</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod<br> tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim <br>veniam, quis nostrud.</p>
                                <a href="#" class="btn border-btn">Learn More <i class="ti-angle-right"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <!-- single Right img -->
            <div class="single-dining-area right-img">
                <div class="container">
                    <div class="row justify-content-start">
                        <div class="col-lg-8 col-md-8">
                            <div class="dining-caption text-right">
                                <span>Our Pool</span>
                                <h3>Swimming Pool</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod<br> tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim <br>veniam, quis nostrud.</p>
                                <a href="#" class="btn border-btn">Learn More  <i class="ti-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
        <!-- Dining End -->


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
    
	<?php require_once 'block/block_footer.php';?> 
    <?php require_once 'block/block_foottag.php'?>
        
    </body>
</html>