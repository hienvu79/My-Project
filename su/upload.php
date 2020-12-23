<?php
require_once('source/dbconnect.php');
mysqli_set_charset($conn, 'UTF8');
//Upload ảnh
if(isset($_POST["phong"])) {
    $phong = $_POST['phong'];
    if(count($_FILES["file"]["name"])){
        for($count=0;$count<count($_FILES["file"]["name"]);$count++){
            $file_name = $_FILES["file"]["name"][$count];
            $tmp_name  = $_FILES["file"]["tmp_name"][$count];
            $file_array = explode('.',$file_name);
            $file_extension = end($file_array);
            if(file_already_uploaded($file_name)){
                $file_name = $file_array[0].'-'.rand().'.'.$file_extension;
            }
            $location = '../upload/'.$file_name;
            if(move_uploaded_file($tmp_name,$location)){
                $sql = mysqli_query($conn,"INSERT INTO img(room_id,img_link) VALUES('$phong','$file_name')");
            }
        }
    }
}
    function file_already_uploaded($file_name){
        $sql = mysqli_query($conn,"SELECT * FROM img WHERE img_link = '$file_name'");
        $num_of_rows = mysqli_num_rows($sql);
        if($num_of_rows>0){
            return true;
        }
        else{
            return false;
        }
    }


?>