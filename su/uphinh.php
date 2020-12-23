<?php
require_once('source/dbconnect.php');
mysqli_set_charset($conn, 'UTF8');
$sql = "SELECT * FROM green_room ORDER BY room_id ASC";
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
        <title>Ajax</title>
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
        <h1 class="h3 mb-2 text-gray-800">Upload</h1>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Upload hình</h6>
                <input type="file" name="multiple_files" id="multiple_files" multiple><br>
                <span class="text-muted">Chỉ cho upload: .jpg,png,gif,jpeg</span>
                <span id="error_multiple_files"></span>
                <form method="POST" id="insert">
                    <select id="phong" class="form-control col-sm-3">
                        <option value="">Chọn phòng</option>
                        <?php 
                            foreach($rows as $row){
                                echo '<option value="'.$row['room_id'].'">'.$row['room_name'].'</option>';
                            }
                        ?>
                    </select><br>
                    <!-- <input class="btn btn-primary" type="button" name="insert" id="button" value="Thêm Ảnh"> -->
                </form>
          </div>
            <div class="card-body">
                <div class="table-responsive" id="image">                             
                        
                </div>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->
      <!-- Footer -->


                        
      <script type="text/javascript">
        $(document).ready(function(){
            function load_image_data(){
                $.ajax({
                    url:"fetch.php",
                    method: "POST",
                    success:function(data){
                        $('#image').html(data);
                    }
                });
            }
            load_image_data();
            //$('#button').on('click',function(){
                $('#multiple_files').change(function(){
                    var phong = $('#phong').val();
                    var error_images = '';
                    var form_data = new FormData();
                    var files   = $('#multiple_files')[0].files;
                    if(files.length>10){
                        error_images+='Bạn không được upload quá 10 hình ảnh';
                    }
                    else{
                        for(var i = 0;i<files.length;i++){
                            var name = document.getElementById('multiple_files').files[i].name;
                            var ext = name.split('.').pop().toLowerCase();
                            if(jQuery.inArray(ext,['gif','png','jpeg','jpg']) == -1){
                                error_images += '<p>Tập tin'+i+'không hiệu lực</p>';
                            }
                            var oFReader = new FileReader();
                            oFReader.readAsDataURL(document.getElementById("multiple_files").files[i]);
                            var f = document.getElementById("multiple_files").files[i];
                            var fsize = f.size||f.fileSize;
                            if(fsize>2000000){
                                error_images += '<p>'+i+'File quá lớn</p>';
                            }
                            else{
                                form_data.append("file[]",document.getElementById('multiple_files').files[i])
                            }
                        }
                    }
                    if(error_images ==''){
                        $.ajax({
                            url:"upload.php",
                            method: "POST",
                            data:{phong:phong,form_data},
                            contentType:false,
                            cache:false,
                            processData:false,
                            beforeSend:function(){
                                $('#error_multiple_files').html('<br><label class="text-primary">Đang tải...</label>');
                            },
                            method: "POST",
                            success:function(data){
                                $('#error_multiple_files').html('<br><label class="text-success">Đã tải thành công</label>');
                                load_image_data();
                            }
                        });
                    }
                });
            //});
        });
    </script>
    <?php require_once 'block/block_footer.php'; ?>

    <?php require_once 'block/block_foottag.php'; ?>
    </body>
</html>