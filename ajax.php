<?php
header('Content-type: application/json; charset=UTF-8');
    if(isset($_GET['f1'])){
        $b = $_POST['b'];
        echo $b;
    }
    else if(isset($_GET['f2'])){
        $c = [
            'a' => '123',
            'b' => '456'
        ];
        echo json_encode($c);
    }
    else if(isset($_GET['f3'])){
        require_once('source/dbconnect.php');
        $sql = "SELECT  *
        FROM green_room ";
        $result = mysqli_query($conn, $sql);
        //print_r($result);
        $rooms = [];
            while ($row = mysqli_fetch_assoc($result)) {
                //print_r($row);
                array_push($rooms, $row);
            }
            //print_r($rooms);
            echo json_encode($rooms,JSON_INVALID_UTF8_IGNORE|JSON_UNESCAPED_UNICODE);
            //echo "test";
    }
    else if(isset($_GET['f4'])){
        require_once('source/dbconnect.php');
        
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if(isset($_POST["ten"])) { $ten = $_POST['ten']; }
            if(isset($_POST["gia"])) { $gia = $_POST['gia'];  }
            if(isset($_POST["dt"])) { $dt = $_POST['dt']; }
            if(isset($_POST["chitiet"])) { $chitiet = $_POST['chitiet']; }
            if(isset($_POST["tienich"])) { $tienich = $_POST['tienich']; }
            if(isset($_POST["status"])) { $status = $_POST['status']; }
            if(isset($_POST["date"])) { $date = $_POST['date']; }
            if(isset($_POST["zone"])) { $zone = $_POST['zone']; }
        $sql = "INSERT INTO green_room(room_name,room_price,room_acreage,room_detail,room_description,room_status,available_date,zone_id) 
        VALUES('$ten','$gia','$dt','$chitiet','$tienich','$status','$date','$zone') ";
        if ($conn->query($sql) === TRUE) {
	        echo "Thêm dữ liệu thành công";
	    } else {
	        echo "Error: " . $sql . "<br>" . $conn->error;
	    }
	}
	//Đóng database
	$conn->close();
        
    }  

?>