<?php 
	if ($_FILES['file']['error'] > 0){
		echo "<script>alert('请选择要上传的文件！');history.go(-1);location.reload();</script>";
		exit();
	}
	$fileName = basename($_FILES['file']['name']);
	$tempName = $_FILES['file']['tmp_name'];
	 
	$date = date("Ymd",time());
	$dir = "F:/news/".$date;
	chmod($dir, 0777);  //修改文件权限
	if (!is_dir($dir)){
		mkdir($dir,0777,true);//创建多级目录
		//echo "<script type='text/javascript'>alert('请在有效的时间内执行修改操作！');history.go(-1);location.reload();</script>";
		//exit();
	}
	$newFile = $dir."/".$fileName;
	 echo $newFile;
	if (is_uploaded_file($_FILES['file']['tmp_name'])){
		$res = move_uploaded_file($_FILES['file']['tmp_name'], iconv("gb2312", "UTF-8", $newFile));
		 
		if (!$res){
			echo "<script>alert('上传失败');history.go(-1);location.reload();</script>";
		}else {
			$title=$_POST['title'];
			$connect = mysqli_connect('localhost','root','','press') or die('Unale to connect');
			if (!$connect)
			{
				die('Could not connect: ' . mysql_error());
			}
			$date=date("Y-m-d h:i:sa",time());
			$sql="INSERT INTO news(title,context,date) value('$title','$newFile','$date')";
			$result=mysqli_query($connect,$sql);
         if(!$result){
            die("Could not enter data:".mysql_error());
         }mysqli_close($conn);
         echo "Entered data successfully!";
			echo "<script>alert('上传成功');history.go(-1);location.reload();</script>";
		}
	}
?>