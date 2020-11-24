<?php 
include ("source/class.php");
$p = new csdl();
$q = new upload();
?> 
<?php
if(isset($_POST["submit"])){
	$con=$p->connect();
	$room_id=$_POST['room_id'];
	if($room_id ==""){
		echo "<script> swal('Chưa nhập mã phòng','Vui lòng nhập mã','error')</script>";
		return false;
	}
	$Mangtype = array("png", "PNG", "gif","GIF", "jpg","JPG", "jpeg");
	
	$mangFile = $_FILES["avatar"];
	//print_r ($mangFile);
	
	for($i=0; $i<count($mangFile["name"]); $i++){
		/////////////////					$_FILES["avatar"]["name"]
		$target_file = "upload/" . basename($mangFile["name"][$i]);
		$uploadOk = 0;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		
		// Check file size  $_FILES["avatar"]["size"]
		if ($mangFile["size"][$i] > 100*1024*1024) {
            echo "<script> swal('Kích thước file quá lớn','Vui lòng chọn file khác','error')</script>";
			$uploadOk = 0;
		} 
		
		// Allow certain file formats
		if( !in_array($imageFileType, $Mangtype) ) {
            echo "<script> swal('Chỉ cho phép file JPG, JPEG, PNG & GIF.','Vui lòng chọn file khác','error')</script>";
			$uploadOk = 0;
		}
		
		// Check if $uploadOk is set to 0 by an error
		
			if (move_uploaded_file($mangFile["tmp_name"][$i], $target_file)) {
				echo "<script> swal('Oke!','Upload thành công','success')</script>";
				$path = $mangFile["name"][$i];
				$q->uphinh($room_id,$path,$con);
			} else {
                echo "<script> swal('Lỗi','Lỗi upload file','error')</script>";
			}
		}	
		/////////////////
	}
	

?>