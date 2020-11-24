<?php ob_start(); ?>
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
  $cus_id = $_SESSION['customer_id'];
  $sql = "SELECT *
  FROM green_appointment AS t1 INNER JOIN green_room AS t2 ON t1.room_id = t2.room_id
  WHERE customer_id = '$cus_id';";
  $result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
  $appointments = [];

  while ($row = mysqli_fetch_assoc($result)) {
    array_push($appointments, $row);
}

} else {
  echo "";
}
mysqli_close($conn);
?>
<!doctype html>
<html class="no-js" lang="zxx">
    <head>
        <title>Đặt Lịch Hẹn</title>
        <?php require_once 'block/block_head.php';?>
        <script src="js/jquery.js"></script>
        <script src="js/timeline.min.js"></script>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/timeline.min.css" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
   </head>
    <style>
    .btn{
    background: #dca73a;
    border-radius: 5px;
    color: #fff;
    display: inline-block;
    font-size: 16px;
    font-weight: 400;
    line-height: 0;
    padding: 25px 20px;
    text-align: center;}
      
label {
    display: inline-block;
    max-width: 100%;
    margin-bottom: 5px;
    font-weight: 500;
}
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
        <div class="container">
			<h3>DANH SÁCH LỊCH HẸN</h3>
			<div class="panel panel-default">
                <div class="panel-body">
                	<div class="timeline">
                        <div class="timeline__wrap">
                            <div class="timeline__items">
                            <?php 
                                if(empty($appointments)){
                                    echo "<div class='timeline__item'>
                                             <div class='timeline__content'>
                                                 <p>Bạn chưa đăng kí lịch</p>
                                            </div>
                                        </div>";
                                }
                                else{
                                    foreach($appointments as $row){
                            ?>
                            	<div class="timeline__item">
                                    <div class="timeline__content">
                                    <h2>Phòng <?php echo $row["room_name"]; ?></h2>
                                    	<p><?php echo $row["appoint_date"]; ?> lúc <?php echo $row["appoint_time"]; ?></p>
                                        <p><a href="timeline.php?id=<?php echo $row['room_id']?>">Xem chi tiết</a></p>
                                    </div>
                                </div>
                                <?php
                                }
                            }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
		</div>
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
   <footer>
        <?php require_once 'block/block_footer.php'?> 
   </footer>
   <!-- Jquery Mobile Menu -->
   <script src="./assets/js/jquery.slicknav.min.js"></script>		
    <script src="./assets/js/popper.min.js"></script>
    <!-- Jquery Slick , Owl-Carousel Plugins -->
    <script src="./assets/js/owl.carousel.min.js"></script>
    <script src="./assets/js/slick.min.js"></script>
    <!-- Date Picker -->
    <script src="./assets/js/gijgo.min.js"></script>
    <!-- Scrollup, nice-select, sticky -->
    <script src="./assets/js/jquery.scrollUp.min.js"></script>
    <script src="./assets/js/jquery.nice-select.min.js"></script>
    <script src="./assets/js/jquery.sticky.js"></script>

    <!-- contact js -->

    <!-- Jquery Plugins, main Jquery -->	
    <script src="./assets/js/plugins.js"></script>
    <script src="./assets/js/main.js"></script>
    </body>
</html>