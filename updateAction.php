<?php

$url= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
//1 用parse_url解析URL,此处是$str
$arr = parse_url($url);


//2 将URL中的参数取出来放到数组里
$arr_query = convertUrlQuery($arr['query']);
var_dump(getUrlQuery($arr_query));


/**
  * Returns the url query as associative array
  * @param     string     query
  * @return     array     params
  */
function convertUrlQuery($query)
{
    $queryParts = explode('&', $query);
    $params = array();
    foreach ($queryParts as $param)
    {
        $item = explode('=', $param);
        $params[$item[0]] = $item[1];
    }
    return $params;
}

function getUrlQuery($array_query)
{
    $tmp = array();
    foreach($array_query as $k=>$param)
    {
        $tmp[] = $k.'='.$param;
    }
    $params = implode('&',$tmp);
    return $params;
}
 ?>
<?php
	if ($_FILES['file']['error'] > 0){
		echo "<script>alert('请选择文件');history.go(-1);location.reload();</script>";
		exit();
	}
	$fileName = basename($_FILES['file']['name']);
	$tempName = $_FILES['file']['tmp_name'];

	$date = date("Ymd",time());
	$dir = "F:/news/".$date;
	chmod($dir, 0777);  //�޸��ļ�Ȩ��
	if (!is_dir($dir)){
		mkdir($dir,0777,true);//�����༶Ŀ¼
		//echo "<script type='text/javascript'>alert('������Ч��ʱ����ִ���޸Ĳ�����');history.go(-1);location.reload();</script>";
		//exit();
	}
	$newFile = $dir."/".$fileName;
	 echo $newFile;
	if (is_uploaded_file($_FILES['file']['tmp_name'])){
		$res = move_uploaded_file($_FILES['file']['tmp_name'], iconv("gb2312", "UTF-8", $newFile));

		if (!$res){
			echo "<script>alert('文件上传');history.go(-1);location.reload();</script>";
		}else {
			$title=$_POST['title'];
			$connect = mysqli_connect('10.18.33.86','H_Z09415124','sujie1997','h_z09415124') or die('Unale to connect');
			if (!$connect)
			{
				die('Could not connect: ' . mysql_error());
			}
			$date=date("Y-m-d h:i:sa",time());
      $id= $arr_query['id'];
      $sql="UPDATE news set  title='$title',context='$newFile',date='$date' where ID=$id";
      echo $sql;
      echo "test";
			$result=mysqli_query($connect,$sql);
         if(!$result){
            die("Could not enter data:".mysql_error());
         }mysqli_close($connect);
         echo "Entered data successfully!";
			echo "<script>alert('更新成功');history.go('-1');location.reload('index.php');</script>";
		}
	}
?>
