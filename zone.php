<?php session_start();?>
<?php
require_once('source/dbconnect.php');
mysqli_set_charset($conn, 'UTF8'); 
    $zone_id = $_GET['zone'];
    $sql = "SELECT  t1.*, MIN(t2.img_id), t2.img_link
    FROM green_room AS t1 INNER JOIN green_room_img AS t2 ON t1.room_id = t2.room_id
    WHERE zone_id ='$zone_id' 
    GROUP BY t2.room_id";
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
        <title>Khu vực <?php echo $rooms[0]['zone_id'];?></title>
        <?php require_once 'block/block_head.php';?>
    </head>

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
                                <span>Danh Sách Phòng</span>
                                <h2>Phòng Của Chúng Tôi</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- slider Area End-->

        <!-- Room Start -->
        <section class="room-area r-padding1">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-8">
                        <!--font-back-tittle  -->
                        <div class="font-back-tittle mb-45">
                            <div class="archivment-front">
                                <h3>Khu vực</h3>
                            </div>
                            <h3 class="archivment-back">Khu vực</h3>
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
                                <div class="per-night">
                                    <span><?php echo $format_num?> VND <span>/ 1 tháng</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                </div>
            </div>

        </section>
        <!-- Room End -->

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

   <footer>
        <?php require_once 'block/block_footer.php'?> 
   </footer>
   
    <?php require_once 'block/block_foottag.php'?> 
    </body>
</html>