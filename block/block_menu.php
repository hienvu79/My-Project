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
                    
                        <?php 
                            if(isset($_SESSION['user']))
                            {
                                ?>
                        <div class="col-xl-10 col-lg-10">
                            <!-- main-menu -->
                            <div class="main-menu f-right d-none d-lg-block">
                                <nav>
                                    <ul id="navigation">                                                                                                                                     
                                        <li><a href="index.php">Trang Chủ</a></li>
                                        <li><a href="rooms.php">Danh Sách Phòng</a><li>
                                        <li><a href="timelines.php">Lịch Hẹn</a></li>
                                        <li><a href="../green-light/cus">Quản Lý</a></li>
                                        <li><a href="#">Xin Chào,<?php echo $_SESSION['user'];?></a></li>
                                        <li><a href="index.php?value=logout">Đăng Xuất</a></li>
                                    <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <div class="col-xl-8 col-lg-8">
                                             <!-- main-menu -->
                                            <div class="main-menu f-right d-none d-lg-block">
                                                <nav>
                                                    <ul id="navigation">                                                                                                                                     
                                                        <li><a href="index.php">Trang Chủ</a></li>
                                                        <li><a href="rooms.php">Danh Sách Phòng</a><li>
                                                        <li><a href="login.php">Đăng Nhập</a></li>
                                                    </ul>
                                                </nav>
                                            </div>
                                        </div>         
                                        <div class="col-xl-2 col-lg-2">
                                            <div class="header-btn">
                                                <a href="#" class="btn btn1 d-none d-lg-block" data-toggle="modal" data-target="#exampleModalCenter">Đăng Ký Ngay</a>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    </ul>
                                </nav>
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
                            <input type="text" id="txtDN" class="form-control" name="user" onBlur="return kiemtratendn();">
                            <span id="tendn" class="text-danger">*</span>
                        </div>
                        <div class="form-group">
                            <label for="user-pass" class="col-form-label">Mật khẩu:</label>
                            <input type="password" id="txtMK" class="form-control" name="pass" onBlur="return kiemtramk();">
                            <span id="mk" class="text-danger">*</span>
                        </div>
                        <div class="form-group">
                            <label for="user-pass" class="col-form-label">Nhập Lại Mật khẩu:</label>
                            <input type="password" id="txtXNMK"  class="form-control" onBlur="return xacnhanmk();">
                            <span id="xnmk" class="text-danger">*</span>
                        </div>
                        <div class="form-group">
                            <label for="cus-name" class="col-form-label">Họ và tên:</label>
                            <input type="text" id="txtName" class="form-control" name="fullname" onBlur="return checkName();">
                            <span id="ten" class="text-danger">*</span>
                        </div>
                        <div class="form-group">
                            <label for="cus-sdt" class="col-form-label">Số Điện Thoại:</label>
                            <input  type="text" id="txtSdt" class="form-control" name="sdt" onBlur="return kiemtrasdt();">
                            <span id="sdt" class="text-danger">*</span>
                        </div>
                        <div class="form-group">
                            <label for="cus-cmnd" class="col-form-label">Số CMND/Thẻ căn cước:</label>
                            <input type="text" id="txtCmnd" class="form-control" name="cmnd" onBlur="return kiemtracmnd();">
                            <span id="cmnd" class="text-danger">*</span>
                        </div>
                        <div class="form-group">
                            <label for="cus-date" class="col-form-label">Ngày sinh:</label>
                            <input type="date" id="txtNs" class="form-control" name="date" onBlur="return kiemtrans();">
                            <span id="date" class="text-danger"></span>
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
    <script>
	function kiemtratendn(){
		var re = /^[a-z]\w*/;
		if(re.test(document.getElementById('txtDN').value.trim())==false){
			tendn.innerText = "*bắt buộc, bắt đầu bằng chữ";
			return false;
		}
		else{
			tendn.innerText = "";
			return true;
		}
	}
	function kiemtramk(){
		var re = /(?=.*\d).{6,}/;
		if(re.test(document.getElementById('txtMK').value.trim())==false){
			mk.innerText = "*phải có chữ, số, ít nhất 6 kí tự";
			return false;
		}
		else{
			mk.innerText = "";
			return true;
		}
	}
	function xacnhanmk(){
		if(document.getElementById('txtXNMK').value != 
		   document.getElementById('txtMK').value){
		   xnmk.innerText = "*phải giống ô mật khẩu";
		   return false;
		}
		else{
			xnmk.innerText = "";
			return true;
		}
	}
	function checkName(){
		var re = /^[A-Za-zÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚÝàáâãèéêìíòóôõùúýĂăĐđĨĩŨũƠơƯưẠ-ỹ\s]+$/;
		if(re.test(document.getElementById('txtName').value.trim()) == false){
		   ten.innerText = "*Kí tự chỉ có chữ không bao gồm số và các kí tự đặc biệt";
		   return false;
		}
		else{
			ten.innerText = "";
			return true;
		}
	}
	function kiemtrans(){
		var ns = new Date(document.getElementById('txtNs').value);
		var today = new Date();
		if(eval(today.getFullYear() - ns.getFullYear()) < 18){
			date.innerText = "*Ít nhất 18 tuổi";
			return false;
		}
		else{
			date.innerText = "";
			return true;
		}
	}
    function kiemtrasdt(){
		var re = /((09|03|07|08|05)+([0-9]{8})\b)/g;
		if(re.test(document.getElementById('txtSdt').value.trim()) == false){
		   sdt.innerText = "*Số điện thoại của bạn không đúng định dạng";
		   return false;
		}
		else{
			sdt.innerText = "";
			return true;
		}
	}
    function kiemtracmnd(){
		var re = /[0-9]$/;
		if(re.test(document.getElementById('txtCmnd').value.trim()) == false){
		   cmnd.innerText = "*Nhập số";
		   return false;
		}
		else{
			cmnd.innerText = "";
			return true;
		}
	}
</script>