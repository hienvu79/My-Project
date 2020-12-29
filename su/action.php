<?php
header('Content-type: application/json; charset=UTF-8');
require_once('source/dbconnect.php');
mysqli_set_charset($conn, 'UTF8');

//Chèn dữ liệu
    if(isset($_POST["ten"])) {
        $ten = $_POST['ten']; 
        $gia = $_POST['gia']; 
        $dientich = $_POST['dientich'];
        $mota = $_POST['mota'];
        $tienich = $_POST['tienich'];
        $khuvuc = $_POST['khuvuc'];
        $result = mysqli_query($conn,"INSERT INTO green_room(room_name,room_price,room_acreage,room_detail,room_description,room_status,zone_id) VALUES('$ten','$gia','$dientich','$mota','$tienich','0','$khuvuc')");
    }
//Delete dữ liệu
if(isset($_POST["room_id"])) {
    $id = $_POST['room_id']; 
    $result = mysqli_query($conn,"DELETE FROM green_room WHERE room_id='$id'");
}

    if(isset($_POST["id"])) {
        $id = $_POST['id']; 
        $text = $_POST['text']; 
        $column_name = $_POST['column_name'];
        $result = mysqli_query($conn,"UPDATE green_room SET $column_name ='$text' WHERE room_id='$id'");
    }
//Lấy dữ liệu
    $output = [];
    $sql_select = mysqli_query($conn,"SELECT * FROM green_room ORDER BY room_id DESC");
    
    if(mysqli_num_rows($sql_select)>0){
        while($rows = mysqli_fetch_assoc($sql_select)){
            array_push($output,$rows);
        }   
    }else{
    }
    echo json_encode($output, JSON_PRETTY_PRINT);


?>
      