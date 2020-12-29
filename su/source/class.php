<?php
class csdl
{
	function connect()
	{
		$con=mysqli_connect("localhost","vnappmob","123456");
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
	function admin($user,$pass,$con)
	{
		$pass_md5=md5($pass);
		$sql="SELECT * FROM green_admin WHERE user_name = '$user';";
		$ketqua=mysqli_query($con,$sql);
		$total_row = mysqli_num_rows($ketqua);
		if($total_row > 0)
		{
			$row = mysqli_fetch_array($ketqua,MYSQLI_ASSOC);
			if($row['user_pass'] == $pass_md5)
			{
				$_SESSION["user"] = $row['user_name'];
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
}
class customer
 {	
	function checkadd($cus_id,$room_id,$join,$expires,$con)
	{
		$sql="SELECT * FROM green_contract WHERE customer_id='$cus_id'";
		$ketqua=mysqli_query($con,$sql);
		$i=mysqli_num_rows($ketqua);
		if ($i>0)
		{
			echo "<script> swal('Khách trọ đã được thêm','Chọn khách trọ khác','error')</script>";
			return false;
		}
		if($cus_id ==""||$room_id ==""||$join ==""||$expires =="")
		{
			echo "<script> swal('Bạn chưa nhập đủ thông tin','Yêu cầu nhập đủ','warning')</script>";
            return false;
		}
		else
		{
			$this->add_cus($cus_id,$room_id,$join,$expires,$con);
			echo "<script> swal('Oke!','Thêm khách trọ thành công','success')</script>";
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
	function checknew($id,$user,$pass,$fullname,$sdt,$cmnd,$ngaysinh,$join,$expires,$con)
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
		if($user == ""||$pass == ""||$fullname == ""||$sdt == ""||$cmnd == ""||$ngaysinh == ""||$join ==""||$expires ==""||$id=="")
		{
			echo "<script> swal('Bạn chưa nhập đủ thông tin','Yêu cầu nhập đủ','warning')</script>";
			return false;
		}
		else
		{
			if (!is_numeric($sdt)||!is_numeric($cmnd)){
				echo "<script> swal('Lỗi','Vui lòng nhập số','error')</script>";
				return false;
			}
			else
			{
				$this->add_new($id,$user,$pass,$fullname,$sdt,$cmnd,$ngaysinh,$join,$expires,$con);
			}
		}
		
	}
	function add_new($id,$user,$pass,$fullname,$sdt,$cmnd,$ngaysinh,$join,$expires,$con)
	{
		$a="INSERT INTO green_customer(customer_name,customer_phone,customer_identity,customer_birthday,user_name,user_pass)
		VALUES('$fullname','$sdt','$cmnd','$ngaysinh','$user','$pass')";
		$b="UPDATE green_room SET room_status='1', available_date='$expires'
		WHERE room_id ='$id'";
		mysqli_query($con,$b);
		if ($con->query($a) === TRUE){
			$cus_id = $con->insert_id;
			$c="INSERT INTO green_contract(customer_id,room_id,contract_datetime,contract_expires) VALUES('$cus_id','$id','$join','$expires')";
			mysqli_query($con,$c);
			echo "<script> swal('Oke!','Thêm khách trọ thành công','success')</script>";
		}
		else
		{
			echo 'Không thành công. Lỗi' . $con->error;
		}
	}
}
class appoint
{
	function datlich($app_id,$con)
	{
		$a = "INSERT INTO green_log(appoint_id,log_content,log_status) VALUES('$app_id','Đặt Lịch Thành Công','1')";
		mysqli_query($con,$a);
		$b = "UPDATE green_log SET log_status = '2' WHERE appoint_id = '$app_id' AND log_status ='0'";
		mysqli_query($con,$b);
		echo "<script> swal('Oke!','Xác nhận lịch thành công','success')</script>";
	}
	function huylich($app_id,$con)
	{
		$a = "INSERT INTO green_log(appoint_id,log_content,log_status) VALUES('$app_id','Lịch Hẹn Bị Hủy','4')";
		mysqli_query($con,$a); 
		$b = "UPDATE green_log SET log_status = '2' WHERE appoint_id = '$app_id' AND log_status ='0'";
		mysqli_query($con,$b);
		echo "<script> swal('Oke!','Hủy hẹn thành công','success')</script>";
	}
	function datcoc($app_id,$con)
	{
		$a = "INSERT INTO green_log(appoint_id,log_content,log_status) VALUES('$app_id','Đã Đặt Cọc','3')";
		mysqli_query($con,$a);
		$b = "UPDATE green_log SET log_status = '2' WHERE appoint_id = '$app_id' AND log_status ='1'";
		mysqli_query($con,$b);
		echo "<script> swal('Oke!','Xác nhận đặt cọc thành công','success')</script>";
	}
	function huycoc($app_id,$con)
	{
		$a = "INSERT INTO green_log(appoint_id,log_content,log_status) VALUES('$app_id','Giao Dịch Thất Bại','6')";
		mysqli_query($con,$a);
		$b = "UPDATE green_log SET log_status = '2' WHERE appoint_id = '$app_id' AND log_status ='1'";
		mysqli_query($con,$b);
		echo "<script> swal('Oke!','Hủy giao dịch thành công','success')</script>";
	}
	function dktamtru($app_id,$con)
	{
		$a = "INSERT INTO green_log(appoint_id,log_content,log_status) VALUES('$app_id','Đã Đăng Ký Tạm Trú','7')";
		mysqli_query($con,$a);
		$b = "UPDATE green_log SET log_status = '2' WHERE appoint_id = '$app_id' AND log_status ='5'";
		mysqli_query($con,$b);
		echo "<script> swal('Oke!','Xác nhận đã đăng ký tạm trú','success')</script>";
	}
}
class contract
{
	function checkprice($id,$app_id,$e_old,$e_price,$w_old,$w_price,$wifi,$cap,$con)
	{
		// $sql="SELECT * FROM green_contract_price WHERE contract_id='$id'";
		// $ketqua=mysqli_query($con,$sql);
		// $i=mysqli_num_rows($ketqua);
		// if ($i>0)
		// {
		// 	echo "<script> swal('Hợp đồng đã thêm','Chọn phòng khác','error')</script>";
		// 	return false;
		// }
		if($e_old == ""||$e_price== ""||$w_old== ""||$w_price== ""||$wifi== ""||$cap==""){
			echo "<script> swal('Thiếu thông tin','Vui lòng nhập đủ','error')</script>";
			return false;
		}
		else
		{
			$this->addprice($id,$app_id,$e_old,$e_price,$w_old,$w_price,$wifi,$cap,$con);
		}
	}
	function addprice($id,$app_id,$e_old,$e_price,$w_old,$w_price,$wifi,$cap,$con)
	{
		$a = "INSERT INTO green_contract_price(contract_id,price_electric,price_water,price_wifi,price_cap) VALUES('$id','$e_price','$w_price','$wifi','$cap')";
		mysqli_query($con,$a);
		$b = "INSERT INTO green_contract_record(contract_id,electric_num_old,electric_num_new,water_num_old,water_num_new) VALUES('$id','$e_old','$e_old','$w_old','$w_old')";
		mysqli_query($con,$b);
		$c = "INSERT INTO green_log(appoint_id,log_content,log_status) VALUES('$app_id','Đang Ở','5')";
		mysqli_query($con,$c);
		$d = "INSERT INTO green_contract_log(contract_id,log_content,log_status) VALUES('$id','Đang Ở','0')";
		mysqli_query($con,$d);
		$e = "UPDATE green_log SET log_status = '2' WHERE appoint_id = '$app_id' AND log_status ='3'";
		mysqli_query($con,$e);
		echo "<script> swal('Oke!','Thêm thành công','success')</script>";
	}
	function addrecord($id,$e_old,$w_old,$e_new,$w_new,$con)
	{
		$a = "INSERT INTO green_contract_record(contract_id,electric_num_old,electric_num_new,water_num_old,water_num_new) VALUES('$id','$e_old','$e_new','$w_old','$w_new')";
		mysqli_query($con,$a);
	}
	function addbill($id,$date,$wifi,$cap,$p_room,$e_num,$e_price,$w_num,$w_price,$incurred,$con)
	{
		print_r($wifi);
		$a1 = "INSERT INTO green_bill(contract_id,bill_date) VALUES('$id','$date')";
		if ($con->query($a1) === TRUE){
			$bill_id = $con->insert_id;
			$a = "INSERT INTO green_bill_items(bill_id,item_name,price,quantity) VALUES('$bill_id','Tiền Phòng','$p_room','1')";
			mysqli_query($con,$a);
			$b = "INSERT INTO green_bill_items(bill_id,item_name,price,quantity) VALUES('$bill_id','Tiền Điện','$e_price','$e_num')";
			mysqli_query($con,$b);
			$c = "INSERT INTO green_bill_items(bill_id,item_name,price,quantity) VALUES('$bill_id','Tiền Nước','$w_price','$w_num')";
			mysqli_query($con,$c);
			$d = "INSERT INTO green_bill_items(bill_id,item_name,price,quantity) VALUES('$bill_id','Tiền Cáp','$cap','1')";
			mysqli_query($con,$d);
			$e = "INSERT INTO green_bill_items(bill_id,item_name,price,quantity) VALUES('$bill_id','Tiền Wifi','$wifi','1')";
			mysqli_query($con,$e);
			$f = "INSERT INTO green_bill_items(bill_id,item_name,price,quantity) VALUES('$bill_id','Chi Phí Khác','$incurred','1')";
			mysqli_query($con,$f);
			$g = "INSERT INTO green_bill_log(bill_id,log_content,log_status) VALUES('$bill_id','Chưa Thu','0')";
			mysqli_query($con,$g);
			echo "<script> swal('Oke!','Thêm hóa đơn thành công','success')</script>";
		}
		else{
			echo 'Không thành công. Lỗi' . $con->error;
		}
	}
	function huy($room_id,$con_id,$app_id,$con)
	{
		$a = "INSERT INTO green_log(appoint_id,log_content,log_status) VALUES('$app_id','Trả Phòng<br>Đã Xác Nhận','9')";
		mysqli_query($con,$a);
		$b = "UPDATE green_contract_log SET contract_id = '$con_id', log_content = 'Xác Nhận Trả Phòng', log_status = '2'
		WHERE log_status = '1'";
		mysqli_query($con,$b);
		$c = "UPDATE green_log SET log_status = '2' WHERE appoint_id = '$app_id' AND log_status ='8'";
		mysqli_query($con,$c);
		echo "<script> swal('Oke','Đã xác nhận','success')</script>";
	}	
	function tracoc($app_id,$room_id,$con_id,$con)
	{
		$a = "UPDATE green_room SET room_status = '0'
		WHERE room_id = '$room_id'";
		mysqli_query($con,$a);
		$b = "INSERT INTO green_log(appoint_id,log_content,log_status) VALUES('$app_id','Kết Thúc Hợp Đồng<br>Đã Trả Cọc<br>Đã Trả Phòng','10')";
		mysqli_query($con,$b);
		$c = "UPDATE green_log SET log_status = '2' WHERE appoint_id = '$app_id' AND log_status ='9'";
		mysqli_query($con,$c);
		$d = "DELETE FROM green_contract_log WHERE contract_id = '$con_id'";
		$e = "DELETE FROM green_contract_price WHERE contract_id = '$con_id'";
		$f = "DELETE FROM green_contract_record WHERE contract_id = '$con_id'";
		$g = "DELETE FROM green_contract WHERE contract_id = '$con_id'";
		mysqli_query($con,$d);
		mysqli_query($con,$e);
		mysqli_query($con,$f);
		mysqli_query($con,$g);
		echo "<script> swal('Oke!','Hoàn tất thủ tục','success')</script>";
	}
	function dathu($bill_id,$con)
	{
		$a = "UPDATE green_bill_log SET log_content = 'Đã Thu', log_status = '1'
		WHERE log_status = '0' AND bill_id = '$bill_id'";
		mysqli_query($con,$a);
		echo "<script> swal('Oke','Đã xác nhận','success')</script>";
	}
}
?>