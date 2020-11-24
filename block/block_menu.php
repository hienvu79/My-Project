<?php
    ob_start();
    if(isset($_GET['value']))
    {
        unset($_SESSION['user']);
    }
?>
<?php 
include ("source/class.php");
$p = new csdl();
$q = new taikhoan();
$e = new appoint();
?>
    <!-- Header Start -->
    <div class="header-area header-sticky">
            <div class="main-header ">
                <div class="container">
                    <div class="row align-items-center">
                        <!-- logo -->
                        <div class="col-xl-2 col-lg-2">
                            <div class="logo">
                               <a href="index.php"><img src="assets/img/logo/logo.png" alt=""></a>
                            </div>
                        </div>
                    <div class="col-xl-8 col-lg-8">
                            <!-- main-menu -->
                            <div class="main-menu f-right d-none d-lg-block">
                                <nav>
                                    <ul id="navigation">                                                                                                                                     
                                        <li><a href="index.php">Trang Chủ</a></li>
                                        <li><a href="rooms.php">Danh Sách Phòng</a><li>
                                <?php 
                                    if(isset($_SESSION['user']))
                                    {
                                        ?>
                                        <li><a href="timelines.php">Lịch Hẹn</a></li>
                                        <li><a href="#">Xin Chào,<?php echo $_SESSION['user'];?></a></li>
                                        <li><a href="index.php?value=logout">Đăng Xuất</a></li>
                                    <?php
                                    }
                                    else
                                    {
                                        echo"
                                        <li><a href='login.php'>Đăng nhập</a></li>
                                        ";
                                    }
                                    ?>
                                    </ul>
                                </nav>
                            </div>
                        </div>           
                        <div class="col-xl-2 col-lg-2">
                            <div class="header-btn">
                                <a href="#" class="btn btn1 d-none d-lg-block" data-toggle="modal" data-target="#exampleModalCenter">Đăng Ký Ngay</a>
                            </div>
                        </div>

                        <!-- Mobile Menu -->
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
            </div>
       </div>
        <!-- Modal register-->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="exampleModalLongTitle">Đăng Ký Thành Viên</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="user-name" class="col-form-label">Tên đăng nhập:</label>
                            <input type="text" class="form-control" name="user">
                        </div>
                        <div class="form-group">
                            <label for="user-pass" class="col-form-label">Mật khẩu:</label>
                            <input type="password" class="form-control" name="pass">
                        </div>
                        <div class="form-group">
                            <label for="cus-name" class="col-form-label">Họ và tên:</label>
                            <input type="text" class="form-control" name="fullname">
                        </div>
                        <div class="form-group">
                            <label for="cus-sdt" class="col-form-label">Số Điện Thoại:</label>
                            <input  type="text" class="form-control" name="sdt">
                        </div>
                        <div class="form-group">
                            <label for="cus-cmnd" class="col-form-label">Số CMND/Thẻ căn cước:</label>
                            <input type="text" class="form-control" name="cmnd">
                        </div>
                        <div class="form-group">
                            <label for="cus-date" class="col-form-label">Ngày sinh:</label>
                            <input type="date" class="form-control" name="date">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button class="btn btn-primary" formmethod="post" type="submit" name="dangky">Đăng Ký</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
            if(isset($_POST['dangky'])){
                $con=$p->connect();
                $user=$_POST['user'];
                $pass=$_POST['pass'];
                $pass=md5($pass);
                $fullname=$_POST['fullname'];
                $sdt=$_POST['sdt'];
                $cmnd=$_POST['cmnd'];
                $ngaysinh=$_POST['date'];
                $q->checkdangky($user,$pass,$fullname,$sdt,$cmnd,$ngaysinh,$con);
            }
        ?>