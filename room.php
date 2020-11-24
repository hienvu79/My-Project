<?php session_start();?>
<?php ob_start();?>
<?php
  require_once 'source/dbconnect.php';
  mysqli_set_charset($conn, 'UTF8'); 
  $id = $_GET['id'];
  $sql = "SELECT * 
  FROM green_room AS t1 INNER JOIN green_room_img AS t2 ON t1.room_id = t2.room_id
                        INNER JOIN green_room_zone AS t3 ON t1.zone_id = t3.zone_id
  WHERE t1.room_id = '$id';";
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
  <html lang="en">
 
  <head>
    <title>Phòng <?php echo $rooms[0]['room_name'];?></title>
    <?php require_once 'block/block_head.php';?>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
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
        <!-- Room Start -->
        <section class="room-area r-padding1">
            <section class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-8">
                        <!--font-back-tittle  -->
                        <div class="font-back-tittle mb-45">
                            <div class="archivment-front">
                                <h3>Phòng Của Chúng Tôi</h3>
                            </div>
                            <h3 class="archivment-back">Phòng Của Chúng Tôi</h3>
                        </div>
                    </div>
                </div>
            <!-- slider Area End-->
                <div class="row">
                    <div class="col-md-5 col-sm-12 col-xs-12">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <?php
                            foreach($rooms as $key => $room){
                                $active_class = $key == 0?"active":"";
                            ?> 
                            <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $key;?>" class="<?php echo $active_class;?>"></li>
                            <?php
                                }
                            ?>
                        </ol>
                        <div class="carousel-inner">
                            <?php 
                            foreach($rooms as $key => $room){
                                $active_class = $key == 0?"active":"";
                                $room_id = $room['room_id']; 
                                //$old = $room['available_date'];          
                                $date = date('d-m-Y',strtotime($room['available_date']));
                                $format_num = number_format($room['room_price']);
                                $status = [
                                    '0' => 'Phòng trống',
                                    '1' => 'Đã cho thuê'
                                ];
                                if($id==$room_id){
                            ?>
                        <div class="carousel-item <?php echo $active_class;?>">
                            <img class="d-block w-100" src="upload/<?php echo $room['img_link']; ?>" alt="First slide">
                        </div>
                        <?php
                            }
                        }
                        ?>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                        </a>
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-12 col-xs-12">
                        <div class="product_title"><h3>Phòng <?php echo $room['room_name'];?></h3></div>
                        <div class="price"><h4>Giá phòng: <b><?php echo $format_num ;?></b> VND</h4></div>
                        <div><h4>Tình trạng: 
                                <?php echo $status[$room['room_status']];?>
                                <?php 
                                    if($room['room_status'] == 1){
                                        if($date == NULL){
                                            echo "";
                                        }
                                        else echo "(sẵn sàng cho thuê vào $date)";
                                    }
                                    else  echo " sẵn sàng cho thuê.";
                                
                                ?>
                            </h4>
                             <h4>Diện tích: <?php echo $room['room_acreage']?>m<sup>2</sup></h4>
                             <h4><?php echo $room['room_detail'];?></h4>
                        </div>
                        <div class="category"><span><a href="rooms.php?id=<?php echo $room['room_id'];?>"></a></span></div>
                        <hr style="border: 1px rotated gray">
                        <div class="description"><h3>Tiện ích</h3>
                            <span><?php echo $room['room_description'];?></span>&emsp;
                        </div><br>
                        <div id="address"><h3>Địa Chỉ</h3>
                            <h4><?php echo $room['zone_address'];?></h4>
                        </div>
                        <div class="cart">  
                        <?php 
                            if($room['room_status']==0)
                            {
                                
                        ?>
                                <a class="btn btn-primary" name="pay" href="appointments.php?room_id=<?php echo $room['room_id']?>">Đặt Hẹn Ngay</a>   
                        <?php
                            }
                            else
                            {
                                echo"<button class='btn btn-success'>Không thể đặt</button>";
                            }
                        ?>
                        </div> 
                </div>
            </div>
        </section> 
    </main>
    <footer>
        <?php require_once 'block/block_footer.php'?> 
    </footer> 

    <?php require_once 'block/block_foottag.php'?> 
    </body>
</html>