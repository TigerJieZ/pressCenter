<?php
	if ($_FILES['file']['error'] > 0){
		echo "<script>alert('��ѡ��Ҫ�ϴ����ļ���');history.go(-1);location.reload();</script>";
		exit();
	}
	$fileName = basename($_FILES['file']['name']);
	$tempName = $_FILES['file']['tmp_name'];

	$date = date("Ymd",time());
	$dir = "F:/news/".$date;
	if (!is_dir($dir)){
		mkdir($dir,0777,true);//�����༶Ŀ¼
		//echo "<script type='text/javascript'>alert('������Ч��ʱ����ִ���޸Ĳ�����');history.go(-1);location.reload();</script>";
		//exit();
	}
	chmod($dir, 0777);  //�޸��ļ�Ȩ��
	$newFile = $dir."/".$fileName;
	echo $newFile;
	if (is_uploaded_file($_FILES['file']['tmp_name'])){
		$res = move_uploaded_file($_FILES['file']['tmp_name'], iconv("gb2312", "UTF-8", $newFile));

		if (!$res){
			echo "<script>alert('文件上传失败');history.go(-1);location.reload();</script>";
		}else {
			$title=$_POST['title'];
			$connect = mysqli_connect('localhost','root','','press') or die('Unale to connect');
			if (!$connect)
			{
				die('Could not connect: ' . mysql_error());
			}
			$date=date("Y-m-d h:i:s",time());
			$sql="INSERT INTO news(title,context,date) value('$title','$newFile','$date')";
			echo $sql;
			$result=mysqli_query($connect,$sql);
         if(!$result){
            die("Could not enter data:".mysql_error());
         }mysqli_close($conn);
         echo "Entered data successfully!";
			echo "<script>alert('发布成功！');history.go(-1);location.reload();</script>";
		}
	}
?>
