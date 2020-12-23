<?php
require_once('source/dbconnect.php');
mysqli_set_charset($conn, 'UTF8');
$sql = mysqli_query($conn,"SELECT * FROM img ORDER BY img_id DESC");
$num_of_rows =  mysqli_num_rows($sql);
$output = '';
$output.= '<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Thứ tự</th>
            <th>Hình ảnh</th>
            <th>ID Phòng</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    ';
    if($num_of_rows>0){
        $count = 0;
        while($row = mysqli_fetch_array($sql)){
            $count++;
            $output.= '
        <tbody>
            <tr>
                <td>'.$count.'</td>
                <td><img src="../upload/'.$row['img_link'].'" class="img img-thumbnail" width="100" height="100"></td>
                <td>'.$row['room_id'].'</td>
                <td><button type ="button" class="btn btn-warning btn-xs edit" id="'.$row['img_id'].'">Edit</button></td>
                <td><button type ="button" class="btn btn-danger btn-xs delete" id="'.$row['img_id'].'">Delete</button></td>
            </tr>
        </tbody>'
            ;
        }
    }
    else{
        $output.= '<tr>
            <td colspan="5" align="center">Chưa có dữ liệu</td>
        </tr>';
    }
$output.='</table>';
echo $output;
?>