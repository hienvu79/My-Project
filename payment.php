<?php session_start();?>
<?php
    if(!isset($_SESSION["user"])){
        header("location: login.php");
    }
?>
<?php
  require_once 'source/dbconnect.php';
  mysqli_set_charset($conn, 'UTF8'); 
  $id = $_GET['id'];
  $sql = "SELECT * 
  FROM green_room 
  WHERE room_id = '$id'";
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
        <?php require_once 'block/block_head.php';?>
        <link rel="stylesheet" href="css/payment.css">
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
                                <span>Green Light</span>
                                <h2>Thanh Toán</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    <?php 
        $num =  $rooms[0]['room_price']*2;
        $format_num = number_format($num);
    ?>
    <div class='container'>
        <div class="card mx-auto col-md-5 col-8 mt-3 p-0"> <img class='mx-auto pic' src="https://i.imgur.com/kXUgBQZ.jpg" />
            <div class="card-title d-flex px-4">
                <p class="item text-muted">Giá Phòng:</p>
                <p><?php echo number_format($rooms[0]['room_price'])?> VND</p>
            </div>
            <div class="card-body">
                <p class="text-muted">Đặc Cọc trước 2 tháng:<span class="indent">
                <?php echo "$format_num"?> VND</span></p>
                <p class="text-muted">Thanh toán</p>
            </div>
            <div class="footer text-center p-0">
                <div class="col-lg-12 col-12 p-0">
                    <script
                        src="https://www.paypal.com/sdk/js?client-id=AUkjBtqbaBxl5TpxXMGunNpJwiQ6RvZujOnyggC0FKYcLJuKUUfJ4g3uFPJ94zAvsmyV1wJWfW6JZITv"> // Required. Replace SB_CLIENT_ID with your sandbox client ID.
                    </script>
                    <div id="paypal-button-container" name="paypal"></div>
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
    paypal.Buttons({
        createOrder: function(data, actions) {
        // This function sets up the details of the transaction, including the amount and line item details.
        return actions.order.create({
            purchase_units: [{
            amount: {
                value: '130'
            }
            }]
        });
        },
        onApprove: function(data, actions) {
        // This function captures the funds from the transaction.
        return actions.order.capture().then(function(details) {
            // This function shows a transaction success message to your buyer.
            //alert('Đơn hàng hoàn tất bởi ' + details.payer.name.given_name);
            swal("Đơn hàng hoàn tất bởi: " + details.payer.name.given_name,"Thanh toán thành công","success");
        });
        }
    }).render('#paypal-button-container');
    //This function displays Smart Payment Buttons on your web page.
    </script>
   <footer>
        <?php require_once 'block/block_footer.php'?> 
   </footer>
   
    <?php require_once 'block/block_foottag.php'?> 
    </body>
</html>