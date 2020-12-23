<?php
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
//Edit dữ liệu
    if(isset($_POST["id"])) {
        $id = $_POST['id']; 
        $text = $_POST['text']; 
        $column_name = $_POST['column_name'];
        $result = mysqli_query($conn,"UPDATE green_room SET $column_name ='$text' WHERE room_id='$id'");
    }
//Lấy dữ liệu
    $output = '';
    $sql_select = mysqli_query($conn,"SELECT * FROM green_room ORDER BY room_id DESC");
    
    if(mysqli_num_rows($sql_select)>0){
        while($rows = mysqli_fetch_array($sql_select)){
            $output .= '
            
                <tr>
                    <td class="ten" data-id1='.$rows['room_id'].' contenteditable>'.$rows['room_name'].'</td>
                    <td class="gia" data-id2='.$rows['room_id'].' contenteditable>'.$rows['room_price'].'</td>
                    <td class="dientich" data-id3='.$rows['room_id'].' contenteditable>'.$rows['room_acreage'].'</td>
                    <td class="mota" data-id4='.$rows['room_id'].' contenteditable>'.$rows['room_detail'].'</td>
                    <td class="tienich" data-id5='.$rows['room_id'].' contenteditable>'.$rows['room_description'].'</td>
                    <td class="status" data-id6='.$rows['room_id'].' contenteditable>'.$rows['room_status'].'</td>
                    <td class="khuvuc" data-id7='.$rows['room_id'].' contenteditable>'.$rows['zone_id'].'</td>
                    <td><button data-id_xoa='.$rows['room_id'].' class="btn btn-sm btn-danger del_data">
                    <i class="fa fa-trash-o" aria-hidden="true"></i></button>
                    </td>
                </tr>
            ';
        }   
    }else{
        $output .='
            <tr>
                <td colspan="8">Dữ liệu chưa có</td>
            </tr>
        ';
    }
    echo $output;
?>