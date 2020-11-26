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
	function dangky($user,$pass,$fullname,$sdt,$cmnd,$ngaysinh,$con)
	{
		$a="insert into green_customer(customer_name,customer_phone,customer_identity,customer_birthday,user_name,user_pass) values ('$fullname','$sdt','$cmnd','$ngaysinh','$user','$pass')";
		mysqli_query($con,$a);
	}
		
	function checkdangky($user,$pass,$fullname,$sdt,$cmnd,$ngaysinh,$con)
	{
		
	$sql="SELECT user_name FROM green_account WHERE user_name='$user'";
	$ketqua=mysqli_query($con,$sql);
	$i=mysqli_num_rows($ketqua);
    if ($i>0)
	{
        echo "<script> swal('Tên đăng nhập bị trùng','Nhập lại tên khác','error')</script>";
        return false;
    }
    if($user == ""||$pass ==""||$fullname==""||$sdt ==""||$cmnd ==""||$ngaysinh =="")
    {
        echo "<script> swal('Bạn chưa nhập đủ thông tin','Yêu cầu nhập đủ','warning')</script>";
        return false;
    }
    else{
		$this->dangky($user,$pass,$fullname,$sdt,$cmnd,$ngaysinh,$con);
		echo "<script> swal('Oke!','Đăng ký thành công','success')</script>";
        }	
	}
}
class upload
{
	function uphinh($room_id,$path,$con)
	{
		$a="insert into green_room_img(room_name,img_link) values('$room_id','$path')";
		mysqli_query($con,$a);
	}
}
class appoint
{
	function checkdatlich($date,$time,$cus_id,$room_id,$con)
	{
		
		$sql="SELECT * FROM green_appointment WHERE customer_id = '$cus_id' AND room_id='$room_id'";
		$ketqua=mysqli_query($con,$sql);
		$i=mysqli_num_rows($ketqua);
		if ($i>0)
		{
			echo "<script> swal('Bạn đã đặt hẹn phòng này','Chọn phòng khác','error')</script>";
			return false;
		}
		$sql="SELECT * FROM green_appointment WHERE appoint_date='$date' AND appoint_time='$time'";
		$ketqua=mysqli_query($con,$sql);
		$i=mysqli_num_rows($ketqua);
		if ($i>0)
		{
			echo "<script> swal('Không thể chọn khung giờ này','Chọn khung giờ khác','error')</script>";
			return false;
		}
		if($date =="" || $time=="")
		{
			echo "<script> swal('Bạn chưa chọn ngày hoặc giờ hẹn','Vui lòng chọn','warning')</script>";
			return false;	
		}
		else{
			$this->datlich($date,$time,$cus_id,$room_id,$con);
			echo "<script> swal('Oke!','Đặt lịch thành công','success')</script>";
		}	
		
	}
	function datlich($date,$time,$cus_id,$room_id,$con)
	{
		
		$a="insert into green_appointment(appoint_date,appoint_time ,customer_id,room_id) values ('$date','$time','$cus_id','$room_id')";
		if ($con->query($a) === TRUE){
			$last_id = $con->insert_id;
			$b="insert into green_log(appoint_id,log_content,log_status) values('$last_id','Chờ Xác Nhận','0')";
			mysqli_query($con,$b);
		}
		else{
			echo 'Không thành công. Lỗi' . $con->error;
		}
	}
}

?>
