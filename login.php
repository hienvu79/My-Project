<?php 
	session_start();
	if(isset($_GET['value']))
	{
		unset($_SESSION['user']);
	}
?>
<?php ob_start();?>

  <!doctype html>
  <html lang="en">
 
  <head>
    <title>Đăng nhập</title>
    <?php require_once 'block/block_head.php';?>
	<script src='https://kit.fontawesome.com/a076d05399.js'></script>
	<style>
		.col-md-5{margin: 0 auto;border: 2px dashed #b1154a;padding:20px;}
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
                                <span>Login</span>
                                <h2>Đăng nhập</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<!-- Room Start -->
		<br>
        <div class="container">
			<form>
				<div class="col-md-5">
				<h2>Đăng nhập</h2>
					<div class="form-group">
						<label for="user-name" class="col-form-label">Tên đăng nhập:</label>
						<input type="text" class="form-control" name="user">
					</div>
					<div class="form-group">
						<label for="user-pass" class="col-form-label">Mật khẩu:</label>
						<input type="password" class="form-control" name="pass">
                    </div>
					<button class="btn btn-primary" formmethod="post" type="submit" name="dangnhap">Đăng nhập</button>
				</div>
			</form>
		</div>
		<br>
	</main>
			<?php
				$con=$p->connect();
				if (isset($_POST['dangnhap']))
				{
					if($_POST['user']!=''&&$_POST['pass']!='')
					{
                        $q->login($_POST['user'],$_POST['pass'],$con);
                        ob_end_flush();
					}
                    else
					{
                        echo "<script> swal('Bạn chưa nhập đủ thông tin','Yêu cầu nhập đủ','warning')</script>";
					}
				}
			  ?>
    <footer>
        <?php require_once 'block/block_footer.php'?> 
    </footer> 

    <?php require_once 'block/block_foottag.php'?> 
    </body>
</html>