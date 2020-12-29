<?php
header('Content-type: application/json; charset=UTF-8');
require_once('source/dbconnect.php');
mysqli_set_charset($conn, 'UTF8');

//Chèn dữ liệu
    if(isset($_POST["name"])) {
        $id = $_POST['room_id'];
        $name=$_POST['name'];
        $sdt=$_POST['sdt'];
        $cmnd=$_POST['cmnd'];
        $birth=$_POST['birth'];
        $join = $_POST['join'];
        $expires = $_POST['expires'];
        $sql = "INSERT INTO green_customer(customer_name,customer_phone,customer_identity,customer_birthday,user_name,user_pass) 
        VALUES('$name','$sdt','$cmnd','$birth','','')"; 
        if ($conn->query($sql) === TRUE) {
            $cus_id = $conn->insert_id;
            $c = mysqli_query($conn,"INSERT INTO green_contract(customer_id,room_id,contract_datetime,contract_expires) 
            VALUES('$cus_id','$id','$join','$expires')");
        }
    }
    //Delete dữ liệu
    if(isset($_POST["cus_id"])) {
        $id = $_POST['cus_id']; 
        $sql = "DELETE FROM green_contract WHERE customer_id='$id'";
        if ($conn->query($sql) === TRUE) {
        $results  = mysqli_query($conn,"DELETE FROM green_customer WHERE customer_id='$id'");
        }
    }

//Sửa dữ liệu
    if(isset($_POST["id"])) {
        $id = $_POST['id']; 
        $room_id = $_POST['room_id'];
        $text = $_POST['text']; 
        $column_name = $_POST['column_name'];
        $result = mysqli_query($conn,"UPDATE green_contract SET $column_name ='$text' WHERE customer_id='$id'");
        $results= mysqli_query($conn,"UPDATE green_customer SET $column_name ='$text' WHERE customer_id='$id'");
        $results= mysqli_query($conn,"UPDATE green_room SET $column_name ='$text' WHERE room_id='$room_id'");
    }
//Lấy dữ liệu
    $output = [];
    $id = $_POST['room_id'];
    $sql_select = mysqli_query($conn,"SELECT * FROM green_contract t1 INNER JOIN green_room t2 ON t1.room_id = t2.room_id 
    INNER JOIN green_customer t3 ON t1.customer_id = t3.customer_id
    LEFT JOIN green_contract_price t4 ON t1.contract_id = t4.contract_id
    WHERE t1.room_id ='$id'
    ORDER BY t1.contract_id DESC");

    if(mysqli_num_rows($sql_select)>0){
        while($rows = mysqli_fetch_assoc($sql_select)){
            array_push($output,$rows);
        }   
    }else{
        
    }
    echo json_encode($output, JSON_PRETTY_PRINT);
//Load Edit
    if(isset($_POST['customer_id'])){
        $output = [];
        $id = $_POST['customer_id'];
        $sql_select = mysqli_query($conn,"SELECT * FROM green_contract t1 INNER JOIN green_room t2 ON t1.room_id = t2.room_id 
        INNER JOIN green_customer t3 ON t1.customer_id = t3.customer_id
        LEFT JOIN green_contract_price t4 ON t1.contract_id = t4.contract_id
        WHERE t1.customer_id ='$id'
        ORDER BY t1.contract_id DESC");

        if(mysqli_num_rows($sql_select)>0){
            while($rows = mysqli_fetch_assoc($sql_select)){
                array_push($output,$rows);
            }   
        }else{
        }
        echo json_encode($output, JSON_PRETTY_PRINT);
    }


?>
      