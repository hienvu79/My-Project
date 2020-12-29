<?php session_start();?>
<?php
    if($_SESSION["user"]!="admin"){
        header("location: login.php");
    }
?>
<?php
require_once('source/dbconnect.php');
mysqli_set_charset($conn, 'UTF8');
$id = $_GET['id'];
$sql = "SELECT * FROM green_contract t1 INNER JOIN green_room t2 ON t1.room_id = t2.room_id 
                                        INNER JOIN green_customer t3 ON t1.customer_id = t3.customer_id
                                        LEFT JOIN green_contract_price t4 ON t1.contract_id = t4.contract_id
        WHERE t1.room_id = '$id'";
    $result = mysqli_query($conn, $sql);
  
  if (mysqli_num_rows($result) > 0) {
    $rooms = [];
  
    while ($row = mysqli_fetch_assoc($result)) {
      array_push($rooms, $row);
  }
  
  } else {
    echo "";
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>

<?php require_once 'block/block_head.php'?>
<title>Thông Tin Phòng</title>
<link rel="stylesheet" href="css/customer.css">
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<style>
.button-list{margin-left:50px;}
</style>
<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
  <?php require_once 'block/block_menu.php';  ?>
    <div class="container-fluid">
    <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">THÔNG TIN KHÁCH TRỌ</h1><br>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#myModal">
            <i class="fas fa-user fa-sm text-white-50"></i> Thêm Khách Trọ</a>
        </div>
        <?php
            if(empty($rooms)){?>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">không có dữ liệu</h6>
                </div>
            <br>
            <?php
            }
            else{
        ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary" id="room_id" data-room_id="<?php if(!empty($rooms)){echo $rooms[0]['room_id'];}else echo"";?>">
              Phòng <?php if(!empty($rooms)){echo $rooms[0]['room_name'];}else echo"";?></h6>
            </div>
            <br>
            <div class="button-list">
            <?php 
            if(!empty($rooms)){
                if(empty($rooms[0]['price_id'])){
                    ?>   
                <a type="button" class="btn btn-primary-rgba" href="input_num.php?id=<?php echo $rooms[0]['room_id'];?>">
                <i class="feather icon-message-square mr-2"></i>Nhập giá trị hợp đồng</a>
                <?php    
                    }
                else echo"";
            }
            ?>
        </div>
          <!-- Content Row -->
        <script src="js/feather.min.js" integrity="sha256-xHkYry2yRjy99N8axsS5UL/xLHghksrFOGKm9HvFZIs=" crossorigin="anonymous"></script>
        <div class="container">
            <div class="row" id="load">
            <!-- Start col -->
            </div>
        </div>
        <?php }?>
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thêm Khách Trọ</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="insert">
                        <div class="form-group">
                            <label for="cus-name" class="col-form-label">Họ và tên:</label>
                            <input type="text" class="form-control" id="name">
                        </div>
                        <div class="form-group">
                            <label for="cus-sdt" class="col-form-label">Số Điện Thoại:</label>
                            <input  type="text" class="form-control" id="sdt">
                        </div>
                        <div class="form-group">
                            <label for="cus-cmnd" class="col-form-label">Số CMND/Thẻ căn cước:</label>
                            <input type="text" class="form-control" id="cmnd">
                        </div>
                        <div class="form-group">
                            <label for="cus-date" class="col-form-label">Ngày sinh:</label>
                            <input type="date" class="form-control" id="birth">
                        </div>
                        <div class="form-group">
                            <label for="cus-date" class="col-form-label">Ngày vào ở:</label>
                            <input type="date" class="form-control" id="join">
                        </div>
                        <div class="form-group">
                            <label for="cus-date" class="col-form-label">Hạn hợp đồng:</label>
                            <input type="text" class="form-control" id="expires" value="<?php if(!empty($rooms)){echo $rooms[0]['contract_expires'];}else echo"";?>" readonly>
                        </div>
                    </form><br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <input class="btn btn-primary" type="button" name="insert" id="button" value="Thêm">
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    function fetch_data(){
        var room_id = $("#room_id").data('room_id');
            $.ajax({
                url: "load.php",
                method: "POST",
                data:{room_id,room_id},
                success:function(data){
                    var load_html = '';
                    for(var i=0;i<data.length;i++){
                        load_html += '\
                    <div class="col-lg-6">\
                        <div class="card m-b-30">\
                            <div class="card-body py-5">\
                                <div class="row">\
                                    <div class="col-lg-3 text-center">\
                                        <img src="img/avatar1.jpg" class="img-fluid mb-3" alt="user" />\
                                    </div>\
                                    <div class="col-lg-9">\
                                        <h4>'+data[i]['customer_name']+'</h4>\
                                        <div class="table-responsive">\
                                            <table class="table table-borderless mb-0">\
                                                <tbody>\
                                                    <tr>\
                                                        <th scope="row" class="p-1">Số CMND :</th>\
                                                        <td class="cmnd" data-id1='+data[i]['customer_id']+' contenteditable>'+data[i]['customer_identity']+'</td>\
                                                    </tr>\
                                                    <tr>\
                                                        <th scope="row" class="p-1">Ngày Sinh :</th>\
                                                        <td class="ns" data-id2='+data[i]['customer_id']+' contenteditable>'+data[i]['customer_birthday']+'</td>\
                                                    </tr>\
                                                    <tr>\
                                                        <th scope="row" class="p-1">Số Điện Thoại :</th>\
                                                        <td class="sdt" data-id3='+data[i]['customer_id']+' contenteditable>'+data[i]['customer_phone']+'</td>\
                                                    </tr>\
                                                    <tr>\
                                                        <th scope="row" class="p-1">Ngày Thuê Trọ :</th>\
                                                        <td class="join" data-id4='+data[i]['customer_id']+' contenteditable>'+data[i]['contract_datetime']+'</td>\
                                                    </tr>\
                                                    <tr>\
                                                        <th scope="row" class="p-1">Ngày Hết Hạn HĐ:</th>\
                                                        <td class="expires" data-id5='+data[i]['customer_id']+' contenteditable>'+data[i]['contract_expires']+'</td>\
                                                    </tr>\
                                                    <tr>\
                                                        <th scope="row" class="p-1">Chỉnh sửa:</th>\
                                                        <td>\
                                                            <button data-id_xoa="'+data[i]['customer_id']+'" class="btn btn-sm btn-danger del_data">\
                                                            <i class="fa fa-trash-o" aria-hidden="true"></i></button>\
                                                            <button id="edit" data-id_sua="'+data[i]['customer_id']+'" class="btn btn-sm btn-primary edit_data" data-toggle="modal" data-target="#myEdit">\
                                                            <i class="fas fa-user" aria-hidden="true"></i></button>\
                                                        </td>\
                                                    </tr>\
                                                </tbody>\
                                            </table>\
                                        </div></div></div></div></div></div>';
                        } 
                    $('#load').html(load_html);
                }
            }); 
        }
    $(document).ready(function(){
        fetch_data();
        //Delete dữ liệu
        $(document).on('click','.del_data ',function(){
            var cus_id = $(this).data('id_xoa');
            if(confirm('Bạn có muốn xóa không ?')){
            $.ajax({
                url: "load.php",
                method: "POST",
                data:{cus_id:cus_id},
                complete:function(data){
                    alert('Xóa dữ liệu thành công.');
                    fetch_data();
                }
            });}
        });   
        // Edit dữ liệu
        function edit_data(id,text,column_name){
            var room_id = $("#room_id").data('room_id');
            $.ajax({
                url: "load.php",
                method: "POST",
                data:{id:id,room_id:room_id,text:text,column_name},
                complete:function(data){
                    //alert('Sửa dữ liệu thành công.');
                    fetch_data();
                }
            });
        }
        $(document).on('blur','.cmnd',function(){
            var id = $(this).data('id1');
            var text = $(this).text();
            edit_data(id,text,"customer_identity");
        });
        $(document).on('blur','.ns',function(){
            var id = $(this).data('id2');
            var text = $(this).text();
            edit_data(id,text,"customer_birthday");
        });
        $(document).on('blur','.sdt',function(){
            var id = $(this).data('id3');
            var text = $(this).text();
            edit_data(id,text,"customer_phone");
        });
        $(document).on('blur','.join',function(){
            var id = $(this).data('id4');
            var text = $(this).text();
            edit_data(id,text,"contract_datetime");
        });
        $(document).on('blur','.expires',function(){
            var id = $(this).data('id5');
            var text = $(this).text();
            edit_data(id,text,"contract_expires");
            edit_data(id,text,"available_date");
        });
        //Insert dữ liệu
        $('#button').on('click',function(){
            var room_id = $("#room_id").data('room_id');
            var name    = $('#name').val();
            var sdt     = $('#sdt').val();
            var cmnd    = $('#cmnd').val();
            var birth   = $('#birth').val();
            var join    = $('#join').val();
            var expires = $('#expires').val();
            if(name ==''||sdt==''||cmnd==''||birth==''||join==''||expires==''){
                swal('Không được bỏ trống','Lỗi','error');
            }
            else{
                $.ajax({
                    url: "load.php",
                    method:"POST",
                    data:{room_id:room_id,name:name,sdt:sdt,cmnd:cmnd,birth:birth,join:join,expires:expires},
                    success:function(data){
                        alert('Thêm dữ liệu thành công');
                        $('#myModal').modal('hide');
                        fetch_data();
                    }
                });
            }
        });
    });
    </script>
    <?php require_once 'block/block_footer.php'; ?>
    <?php require_once 'block/block_foottag.php'; ?>
</body>

</html>