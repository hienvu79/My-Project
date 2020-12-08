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
}
class contract
{
	function huy($con_id,$app_id,$date,$con)
	{
		$a = "INSERT INTO green_log(appoint_id,log_content,log_status,log_date) VALUES('$app_id','Kết Thúc Hợp Đồng','7','$date')";
		mysqli_query($con,$a);
		$b = "INSERT INTO green_contract_log(contract_id,log_content,log_status) VALUES('$con_id','Kết Thúc Hợp Đồng','1')";
		mysqli_query($con,$b);
		echo "<script> swal('Oke','Bạn đã chọn kết thúc hợp đồng','success')</script>";
	}
}
class customer
 {	
	function checknew($room_id,$fullname,$sdt,$cmnd,$ngaysinh,$join,$expires,$e_price,$w_price,$wifi,$cap,$con)
	{		
		$sql="SELECT * FROM green_customer WHERE customer_identity='$cmnd'";
		$ketqua=mysqli_query($con,$sql);
		$i=mysqli_num_rows($ketqua);
		if ($i>0)
		{
			echo "<script> swal('Khách trọ đã thêm','Vui lòng chọn khách trọ khác','error')</script>";
			return false;
		}	
		if($fullname == ""||$sdt == ""||$cmnd == ""||$ngaysinh == ""||$join =="")
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
				$this->add_new($room_id,$fullname,$sdt,$cmnd,$ngaysinh,$join,$expires,$e_price,$w_price,$wifi,$cap,$con);
				echo "<script> swal('Oke!','Thêm bạn trọ thành công','success')</script>";
			}
		}
		
	}
	function add_new($room_id,$fullname,$sdt,$cmnd,$ngaysinh,$join,$expires,$e_price,$w_price,$wifi,$cap,$con)
	{
		$a="INSERT INTO green_customer(customer_name,customer_phone,customer_identity,customer_birthday,user_name,user_pass)
		VALUES('$fullname','$sdt','$cmnd','$ngaysinh','','')";
		if ($con->query($a) === TRUE){
			$cus_id = $con->insert_id;
			$c="INSERT INTO green_contract(customer_id,room_id,contract_datetime,contract_expires) VALUES('$cus_id','$room_id','$join','$expires')";
			if ($con->query($c) === TRUE){
				$con_id = $con->insert_id;
				$d = "INSERT INTO green_contract_log(contract_id,log_content,log_status) VALUES('$con_id','Đang Ở','0')";
				mysqli_query($con,$d);
				$e = "INSERT INTO green_contract_price(contract_id,price_electric,price_water,price_wifi,price_cap) VALUES('$con_id','$e_price','$w_price','$wifi','$cap')";
				mysqli_query($con,$e);
			}
		}
		else
		{
			echo 'Không thành công. Lỗi' . $con->error;
		}
	}
}
?>