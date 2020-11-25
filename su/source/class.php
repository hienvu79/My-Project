<?php
class csdl
{
	function connect()
	{
		$con=mysqli_connect("db","vnappmob","123456");
		if(!$con)
		{
			echo 'Không kết nối csdl';
			return false;
		}
		else
		{
			mysqli_select_db($con,"greenlight_motel_app");
			mysqli_set_charset($con, 'UTF8');
			return $con;
		}
	}
}
class taikhoan
{
	function login($user,$pass,$con)
		{
			$pass_md5=md5($pass);
			$sql="SELECT * FROM green_customer WHERE user_name = '$user';";
			$ketqua=mysqli_query($con,$sql);
			$total_row = mysqli_num_rows($ketqua);
			if($total_row > 0)
			{
				$row = mysqli_fetch_array($ketqua,MYSQLI_ASSOC);
				if($row['user_pass'] == $pass_md5)
				{
					$_SESSION["user"] = $row['user_name'];
					$_SESSION["customer_id"] = $row['customer_id'];
					header("location:index.php");
				}
				else
				{
					echo "<script> swal('Tên đăng nhập hoặc mật khẩu sai','Vui lòng nhập lại','error')</script>";
					return false;
				}
			}
			else
			{
				echo "<script> swal('Tên đăng nhập hoặc mật khẩu sai','Vui lòng nhập lại','error')</script>";
				return false;
			}
			
		}
	function admin($user,$pass)
	{
		if ($user == "admin" && $pass == "123456") {
            echo "<script> swal('Thành Công!', 'Bạn Đã Đăng Nhập Với Tư Cách Admin', 'success')</script>";
			$_SESSION["user"] = $user;
			header("location:index.php");
            return true;
        }
        if ($user == "" && $pass == "") {
            echo "<script> swal('Bạn Chưa Nhập Thông Tin!', 'Vui Lòng Kiểm Tra Lại', 'warning')</script>";
            return false;
        }
        if ($user == "") {
            echo "<script> swal('Bạn Chưa Nhập Tài Khoản', 'Vui Lòng Kiểm Tra Tài Khoản', 'error')</script>";
            return false;
        } 
        if ($pass == "") {
            echo "<script> swal('Bạn Chưa Nhập Mật Khẩu', 'Vui Lòng Kiểm Tra Mật Khẩu', 'error')</script>";
            return false;
        }
        echo "<script> swal('Thông Tin Bạn Nhập Không Tồn Tại', 'Vui Lòng Kiểm Tra Hoặc Nhấn Quên Mật Khẩu', 'error')</script>";
	}
}
class customer
 {	
	function checkadd($cus_id,$room_id,$join,$expires,$con)
	{
		if($cus_id == ""||$room_id == ""||$join ==""||$expires =="")
		{
			echo "<script> swal('Bạn chưa nhập đủ thông tin','Yêu cầu nhập đủ','warning')</script>";
            return false;
		}
		else{
			$sql="SELECT * FROM green_contract WHERE customer_id='$cus_id'";
			$ketqua=mysqli_query($con,$sql);
			$i=mysqli_num_rows($ketqua);
			if ($i>0)
			{
				echo "<script> swal('Khách trọ đã thêm','Chọn khách trọ khác','error')</script>";
				return false;
			}
			else{
				$this->add_cus($cus_id,$room_id,$join,$expires,$con);
				echo "<script> swal('Oke!','Thêm khách trọ thành công','success')</script>";
			}
		}
	}
	function add_cus($cus_id,$room_id,$join,$expires,$con)
	{
		$a="INSERT INTO green_contract(customer_id,room_id,contract_datetime,contract_expires)
		VALUES('$cus_id','$room_id','$join','$expires')";
		mysqli_query($con,$a);
		$b="UPDATE green_room SET room_status='1', available_date='$expires'
		WHERE room_id ='$room_id'";
		mysqli_query($con,$b);
	}
	function checknew($user,$pass,$fullname,$sdt,$cmnd,$ngaysinh,$room_id,$join,$expires,$con)
	{
		if($user == ""||$pass == ""||$fullname == ""||$sdt == ""||$cmnd == ""||$ngaysinh == ""||$room_id == ""||$join ==""||$expires =="")
		{
			echo "<script> swal('Bạn chưa nhập đủ thông tin','Yêu cầu nhập đủ','warning')</script>";
			return false;
		}
		else
		{
			$sql="SELECT * FROM green_customer WHERE user_name='$user'";
			$ketqua=mysqli_query($con,$sql);
			$i=mysqli_num_rows($ketqua);
			if ($i>0)
			{
				echo "<script> swal('Tên đăng nhập bị trùng','Chọn tên đăng nhập khác','error')</script>";
				return false;
			}
			$sql="SELECT * FROM green_customer WHERE customer_identity='$cmnd'";
			$ketqua=mysqli_query($con,$sql);
			$i=mysqli_num_rows($ketqua);
			if ($i>0)
			{
				echo "<script> swal('Khách trọ đã thêm','Vui lòng chọn khách trọ khác','error')</script>";
				return false;
			}	
			if (!is_numeric($sdt)||!is_numeric($cmnd)){
				echo "<script> swal('Lỗi','Vui lòng nhập số','error')</script>";
				return false;
			}
			else
			{
				$this->add_new($user,$pass,$fullname,$sdt,$cmnd,$ngaysinh,$room_id,$join,$expires,$con);
				echo "<script> swal('Oke!','Thêm khách trọ thành công','success')</script>";
			}
		}
		
	}
	function add_new($user,$pass,$fullname,$sdt,$cmnd,$ngaysinh,$room_id,$join,$expires,$con)
	{
		$a="INSERT INTO green_customer(customer_name,customer_phone,customer_identity,customer_birthday,user_name,user_pass)
		VALUES('$fullname','$sdt','$cmnd','$ngaysinh','$user','$pass')";
		$b="UPDATE green_room SET room_status='1', available_date='$expires'
		WHERE room_id ='$room_id'";
		mysqli_query($con,$b);
		if ($con->query($a) === TRUE){
			$cus_id = $con->insert_id;
			$c="INSERT INTO green_contract(customer_id,room_id,contract_datetime,contract_expires) values('$cus_id','$room_id','$join','$expires')";
			mysqli_query($con,$c);
		}
		else{
			echo 'Không thành công. Lỗi' . $con->error;
		}
	}
	function xoa($con,$id)
	{
		$a = "DELETE FROM products WHERE product_id = '$id'";
		$b = "DELETE FROM product_img WHERE product_id = '$id'";
		mysqli_query($con,$a);
		mysqli_query($con,$b);
		echo "<script> swal('Oke!','Xóa sản phẩm thành công','success')</script>";
	}
	function sua($con,$pro_id,$tensp,$cat_id,$gia,$giakm,$mota,$sphot,$img_url)
	{
		$a = "UPDATE products 
		SET product_title = '$tensp', category_id = '$cat_id', product_price = '$gia', product_discount = '$giakm', product_description = '$mota', popular = '$sphot'
		WHERE product_id = '$pro_id'";
		$b = "UPDATE product_img 
		SET img_url = '$img_url'
		WHERE product_id = '$pro_id'";
		mysqli_query($con,$a);
		mysqli_query($con,$b);
		echo "<script> swal('Oke!','Sửa sản phẩm thành công','success')</script>";
	}
}
class appoint
{
	function datlich($app_id,$con)
	{
		$a = "INSERT INTO green_log(appoint_id,log_content,log_status) VALUES('$app_id','Đặt Lịch Thành Công','1')";
		mysqli_query($con,$a);
		echo "<script> swal('Oke!','Xác nhận lịch thành công','success')</script>";
		$b = "INSERT INTO green_log(appoint_id,log_content,log_status) VALUES('$app_id','Đặt Cọc','2')";
		mysqli_query($con,$b);
		$c = "INSERT INTO green_log(appoint_id,log_content,log_status) VALUES('$app_id','Đăng Ký Tạm Trú','4')";
		mysqli_query($con,$c);
	}
	function huylich($app_id,$con)
	{
		$a = "INSERT INTO green_log(appoint_id,log_content,log_status) VALUES('$app_id','Lịch Hẹn Bị Hủy','6')";
		mysqli_query($con,$a);
		echo "<script> swal('Oke!','Hủy hẹn thành công','success')</script>";
	}
	function datcoc($app_id,$con)
	{
		$a = "UPDATE green_log SET appoint_id = '$app_id', log_content = 'Đã Đặt Cọc', log_status = '3'
		WHERE log_status = '2'";
		mysqli_query($con,$a);
		echo "<script> swal('Oke!','Xác nhận đặt cọc thành công','success')</script>";
	}
	function dktamtru($app_id,$con)
	{
		$a = "UPDATE green_log SET appoint_id = '$app_id', log_content = 'Đã Đăng Ký Tạm Trú', log_status = '5'
		WHERE log_status = '4'";
		mysqli_query($con,$a);
		echo "<script> swal('Oke!','Xác nhận đã đăng ký tạm trú','success')</script>";
	}
}
class contract
{
	function checkprice($id,$e_old,$e_price,$w_old,$w_price,$wifi,$cap,$con)
	{
		$sql="SELECT * FROM green_contract_price WHERE contract_id='$id'";
		$ketqua=mysqli_query($con,$sql);
		$i=mysqli_num_rows($ketqua);
		if ($i>0)
		{
			echo "<script> swal('Hợp đồng đã thêm','Chọn phòng khác','error')</script>";
			return false;
		}
		if($e_old == ""||$e_price== ""||$w_old== ""||$w_price== ""||$wifi== ""||$cap==""){
			echo "<script> swal('Thiếu thông tin','Vui lòng nhập đủ','error')</script>";
			return false;
		}
		else
		{
			$this->addprice($id,$e_old,$e_price,$w_old,$w_price,$wifi,$cap,$con);
		}
	}
	function addprice($id,$e_old,$e_price,$w_old,$w_price,$wifi,$cap,$con)
	{
		$a = "INSERT INTO green_contract_price(contract_id,price_electric,price_water,price_wifi,price_cap) VALUES('$id','$e_price','$w_price','$wifi','$cap')";
		mysqli_query($con,$a);
		$b = "INSERT INTO green_contract_record(contract_id,electric_num_old,electric_num_new,water_num_old,water_num_new) VALUES('$id','$e_old','$e_old','$w_old','$w_old')";
		mysqli_query($con,$b);
		echo "<script> swal('Oke!','Thêm thành công','success')</script>";
	}
	function addrecord($id,$e_old,$w_old,$e_new,$w_new,$con)
	{
		$a = "INSERT INTO green_contract_record(contract_id,electric_num_old,electric_num_new,water_num_old,water_num_new) VALUES('$id','$e_old','$e_new','$w_old','$w_new')";
		mysqli_query($con,$a);
		echo "<script> swal('Oke!','Thêm chỉ số thành công','success')</script>";
	}
	// function checkbill($id,$timestamp,$wifi,$cap,$p_room,$e_num,$e_price,$w_num,$w_price,$incurred,$dept,$status,$status1,$con)
	// {
	// 	$sql="SELECT * FROM `green_bill` WHERE contract_id = '$id' AND bill_datetime = '$timestamp'";
	// 	$ketqua=mysqli_query($con,$sql);
	// 	$i=mysqli_num_rows($ketqua);
	// 	if ($i>0)
	// 	{
	// 		echo "<script> swal('Hóa đơn phòng đã được thêm','Chọn phòng khác','error')</script>";
	// 		return false;
	// 	}
	// 	else
	// 	{
	// 		$this->addbill($id,$wifi,$cap,$p_room,$e_num,$e_price,$w_num,$w_price,$incurred,$dept,$status,$status1,$con);
	// 	}
	// }
	function addbill($id,$date,$wifi,$cap,$p_room,$e_num,$e_price,$w_num,$w_price,$incurred,$dept,$status,$status1,$status2,$status3,$con)
	{
		$a1 = "INSERT INTO green_bill(contract_id,bill_date) VALUES('$id','$date')";
		if ($con->query($a1) === TRUE){
			$bill_id = $con->insert_id;
			$a = "INSERT INTO green_bill_items(bill_id,item_name,price,quantity) VALUES('$bill_id','Tiền Phòng','$p_room','1')";
			mysqli_query($con,$a);
			$b = "INSERT INTO green_bill_items(bill_id,item_name,price,quantity) VALUES('$bill_id','Tiền Điện','$e_price','$e_num')";
			mysqli_query($con,$b);
			$c = "INSERT INTO green_bill_items(bill_id,item_name,price,quantity) VALUES('$bill_id','Tiền Nước','$w_price','$w_num')";
			mysqli_query($con,$c);
			$d = "INSERT INTO green_bill_items(bill_id,item_name,price,quantity) VALUES('$bill_id','Tiền Cáp','$cap','$status1')";
			mysqli_query($con,$d);
			$e = "INSERT INTO green_bill_items(bill_id,item_name,price,quantity) VALUES('$bill_id','Tiền Wifi','$wifi','$status')";
			mysqli_query($con,$e);
			$f = "INSERT INTO green_bill_items(bill_id,item_name,price,quantity) VALUES('$bill_id','Chi Phí Khác','$incurred','$status2')";
			mysqli_query($con,$f);
			$g = "INSERT INTO green_bill_items(bill_id,item_name,price,quantity) VALUES('$bill_id','Tiền Nợ','$dept','$status3')";
			mysqli_query($con,$g);
			$h = "INSERT INTO green_bill_date(bill_id,contract_id) VALUES('$bill_id','$id')";
			mysqli_query($con,$h);
			echo "<script> swal('Oke!','Thêm hóa đơn thành công','success')</script>";
		}
		else{
			echo 'Không thành công. Lỗi' . $con->error;
		}
	}
}
?>