<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>UpLoad Hình</title>
    <!-- Latest compiled and minified CSS -->
    <?php require_once 'block/block_head.php';?>
    <link rel="stylesheet" href="css/style.css" >
    
<style>
.btn{margin-bottom:20px;}
input[type=submit] {
    margin-top: 20px;
}
</style>
<script type="text/javascript" src="jquery-3.1.0.min.js"></script>
<script>
$(document).ready(function(){
	$("#btnThemFile").click(function(){
		$("#chonFile").append("<br/><input name='avatar[]' type='file' />");	
	});	
});
</script>
</head>

<body>
<form class="form-signin" action="" method="post" enctype="multipart/form-data">
    <h2 class="form-signin-heading">Upload Ảnh Phòng</h2>
    <div class="form-group">
        <label for="InputFile">Nhập mã phòng:</label>
        <input type="text" name="room_id">
    </div>
    <button type="button" id="btnThemFile" class="btn btn-success">Thêm ảnh</button>
    <div id="chonFile">
        <input name='avatar[]' type='file' />
    </div>
    
    <input name="submit" type="submit" value="Thêm" />

</form>
<?php require_once 'loadhinh.php';?>
</body>
</html>