<?php session_start();?>
<?php
    if($_SESSION["user"]!="admin"){
        header("location: login.php");
    }
?>
<?php
require_once('source/dbconnect.php');
mysqli_set_charset($conn, 'UTF8');
$sql = "SELECT * FROM green_room_zone ORDER BY zone_id ASC";
$result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
      $rows = [];
    
      while ($row = mysqli_fetch_assoc($result)) {
        array_push($rows, $row);
    }
    
    } else {
      echo "";
    }
?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <title>Quản lý phòng</title>
    <?php require_once 'block/block_head.php'?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  </head>
<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

  <?php require_once 'block/block_menu.php';  ?>
    <!-- End of Sidebar -->
  </div>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800"></h1>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Quản lý phòng</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="col-md-3">
                        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Thêm Phòng</button>
                    </div>
                    <br>
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tên Phòng</th>
                                <th>Giá Phòng</th>
                                <th>Diện Tích</th>
                                <th>Mô Tả</th>
                                <th>Tiện Ích</th>
                                <th>Tình Trạng</th>
                                <th>Khu Vực</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="load">

                        </tbody>
                    </table>
                </div>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->
      <!-- Footer -->
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thêm Phòng</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="insert">
                        <label class="col-form-label">Tên Phòng:</label>
                        <input type="text" class="form-control" id="ten">
                        <label class="col-form-label">Giá Phòng:</label>
                        <input type="text" class="form-control" id="gia">
                        <label class="col-form-label">Diện tích:</label>
                        <input type="text" class="form-control" id="dientich">
                        <label class="col-form-label">Mô tả:</label>
                        <input type="text" class="form-control" id="mota">
                        <label class="col-form-label">Tiện ích:</label>
                        <input type="text" class="form-control" id="tienich">
                        <label class="col-form-label">Khu vực:</label>
                        <select id="khuvuc" class="form-control">
                            <option value="">Chọn khu vực</option>
                            <?php 
                                foreach($rows as $row){
                                    echo '<option value="'.$row['zone_id'].'">'.$row['zone_name'].'</option>';
                                }
                            ?>
                        </select>
                        <br>
                        
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
            $.ajax({
                url: "action.php",
                method: "POST",
                success:function(data){
                   
                    var load_html = '';
                    for(var i=0;i<data.length;i++){
                        load_html += '<tr>\
                            <td class="ten" data-id1='+data[i]['room_id']+' contenteditable>'+data[i]['room_name']+'</td>\
                            <td class="gia" data-id2='+data[i]['room_id']+' contenteditable>'+data[i]['room_price']+'</td>\
                            <td class="dientich" data-id3='+data[i]['room_id']+' contenteditable>'+data[i]['room_acreage']+'</td>\
                            <td class="mota" data-id4='+data[i]['room_id']+' contenteditable>'+data[i]['room_detail']+'</td>\
                            <td class="tienich" data-id5='+data[i]['room_id']+' contenteditable>'+data[i]['room_description']+'</td>\
                            <td class="status" data-id6='+data[i]['room_id']+' contenteditable>'+data[i]['room_status']+'</td>\
                            <td class="khuvuc" data-id7='+data[i]['room_id']+' contenteditable>'+data[i]['zone_id']+'</td>\
                            <td><button data-id_xoa="'+data[i]['room_id']+'" class="btn btn-sm btn-danger del_data">\
                            <i class="fa fa-trash-o" aria-hidden="true"></i></button>\
                            </td>\
                        </tr>';
                    } 
                    $('#load').html(load_html);
                }
            }); 
        }
    
    $(document).ready(function(){
        fetch_data();
        //Delete dữ liệu
        $(document).on('click','.del_data ',function(){
            var room_id = $(this).data('id_xoa');
            if(confirm('Bạn có muốn xóa không ?')){
            $.ajax({
                url: "action.php",
                method: "POST",
                data:{room_id:room_id},
                success:function(data){
                    alert('Xóa dữ liệu thành công.');
                    fetch_data();
                }
            });}
        });   
       // Edit dữ liệu
        function edit_data(id,text,column_name){
            $.ajax({
                url: "action.php",
                method: "POST",
                data:{id:id,text:text,column_name},
                success:function(data){
                    //alert('Sửa dữ liệu thành công.');
                    fetch_data();
                }
            });
        }
        $(document).on('blur','.ten',function(){
            var id = $(this).data('id1');
            var text = $(this).text();
            edit_data(id,text,"room_name");
        });
        $(document).on('blur','.gia',function(){
            var id = $(this).data('id2');
            var text = $(this).text();
            edit_data(id,text,"room_price");
        });
        $(document).on('blur','.dientich',function(){
            var id = $(this).data('id3');
            var text = $(this).text();
            edit_data(id,text,"room_acreage");
        });
        $(document).on('blur','.mota',function(){
            var id = $(this).data('id4');
            var text = $(this).text();
            edit_data(id,text,"room_detail");
        });
        $(document).on('blur','.tienich',function(){
            var id = $(this).data('id5');
            var text = $(this).text();
            edit_data(id,text,"room_description");
        });
        $(document).on('blur','.status',function(){
            var id = $(this).data('id6');
            var text = $(this).text();
            edit_data(id,text,"room_status");
        });
        $(document).on('blur','.khuvuc',function(){
            var id = $(this).data('id7');
            var text = $(this).text();
            edit_data(id,text,"zone_id");
        });
        
        //Chèn dữ liệu
        $('#button').on('click',function(){
            var ten = $('#ten').val();
            var gia = $('#gia').val();
            var dientich = $('#dientich').val();
            var mota = $('#mota').val();
            var tienich = $('#tienich').val();
            var khuvuc = $('#khuvuc').val();
            
            if(ten == ''||gia ==''||dientich ==''||mota ==''||tienich ==''||khuvuc ==''){
                swal('Không được bỏ trống','Lỗi','error');
            }
            else{
                $.ajax({
                    url: "action.php",
                    method: "POST",
                    data:{ten:ten,gia:gia,dientich:dientich,mota:mota,tienich:tienich,khuvuc:khuvuc},
                    success:function(data){
                        alert('Thêm dữ liệu thành công.');
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
