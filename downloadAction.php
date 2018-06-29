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
      $id= $arr_query['Gid'];
			$title=$_POST['title'];
			$connect = mysqli_connect('10.18.33.86','H_Z09415124','sujie1997','h_z09415124') or die('Unale to connect');
      mysqli_query($connect,"set names utf8");
			if (!$connect)
			{
				die('Could not connect: ' . mysql_error());
			}
      $content=$_POST['content'];
      $sql = "select context from news where id=$id;";
     // 执行sql语句返回结果集
     $result = mysqli_query($connect,$sql);
     while($row = mysqli_fetch_array($result))
     {
       $context_name=$row['context'];
        if (! file_exists ($context_name)) {
            header('HTTP/1.1 404 NOT FOUND');
        } else {
            //以只读和二进制模式打开文件
            $file = fopen ($context_name, "rb" );
            //告诉浏览器这是一个文件流格式的文件
            Header ( "Content-type: application/octet-stream" );
            //请求范围的度量单位
            Header ( "Accept-Ranges: bytes" );
            //Content-Length是指定包含于请求或响应中数据的字节长度
            Header ( "Accept-Length: " . filesize ($context_name) );
            //用来告诉浏览器，文件是可以当做附件被下载，下载后的文件名称为$file_name该变量的值。
            Header ( "Content-Disposition: attachment; filename=" . $context_name );

            //读取文件内容并直接输出到浏览器
            echo fread ( $file, filesize ($context_name) );
            fclose ( $file );
            exit ();
        }
     }
?>
