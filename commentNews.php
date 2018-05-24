<?php

$url= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
//1 用parse_url解析URL,此处是$str
$arr = parse_url($url);


//2 将URL中的参数取出来放到数组里
$arr_query = convertUrlQuery($arr['query']);
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
<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400">  <!-- Google web font "Open Sans" -->
<head>
    <meta charset="UTF-8">
    <title>查找新闻</title>
</head>
<body>
<br>
<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<nav class="navbar navbar-default" role="navigation">
				<div class="navbar-header">
					 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button> <a class="navbar-brand" href="index.php">Home</a>
				</div>

				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li >
							 <a href="addNews.php">发布新闻</a>
						</li>
						<li>
							<a href="searchNews.php">查找新闻</a>
						</li>
						<li >
							<a href="manageNews.php">管理新闻</a>
						</li>
            <li>
							<a href="manageComments.php">管理评论</a>
						</li>
            <li class="active">
							<a href="manageComments.php">新闻详情</a>
						</li>
					</ul>
					<form class="navbar-form navbar-right" role="search" action="searchNews.php" method="POST">
						<div class="form-group">
							<input type="text" class="form-control" name="key"/>
						</div> <button type="submit" class="btn btn-default">Search</button>
					</form>
				</div>

			</nav>
			<div class="jumbotron">
				<h1>
					Hello, world!
				</h1>
				<p>
					This is a template for a simple marketing or informational website. It includes a large callout called the hero unit and three supporting pieces of content. Use it as a starting point to create something more unique.
				</p>
				<p>
					 <a class="btn btn-primary btn-large" href="#">Learn more</a>
				</p>
			</div>
		</div>
	</div>
	<div class="row clearfix">
    <div class="col-md-3 column"></div>
	   <?php
		try {
      $id=$arr_query['id'];
			if($id>=0){
				$connect = mysqli_connect('localhost','root','','press') or die('Unale to connect');
        mysqli_query($connect,"set names utf8");
				if (!$connect)
				{
					die('Could not connect: ' . mysql_error());
				}
				//��ѯ�������ݲ���json�ĸ�ʽ���
				$sql = "select * from news where ID =$id";
				// ִ��sql��䷵�ؽ����
				$result = mysqli_query($connect,$sql);

				while($row = mysqli_fetch_array($result))
				{
					echo "<div class=\"col-md-6 column\"><center><h2>";
					echo $row['title'];
					echo "</h2></center><p>";
					// ��ȡ����
					$context_name=$row['context'];
					$myfile = fopen($context_name, "r") or die("Unable to open file!");
					echo fread($myfile,filesize($context_name));
					fclose($myfile);
					echo "</p>";
				}
			}else{
				echo "请输入要评论的新闻ID";
			}

		} catch (Exception $e) {
			echo "请输入要评论的新闻ID";
		}
		?><br><br>
    <?php
    $sql="SELECT * FROM comments where newsID=$id and state=1";
    $result = mysqli_query($connect,$sql);

    while($row = mysqli_fetch_array($result))
    {
      $temp=$row['context'];
      $temp_date=$row['date'];
      echo $temp;
      echo "<br>";
      echo "<div style=\"float:right;color:red;\">";
      echo $temp_date;
      echo "</div>";
      echo "<legend> </legend><br><br>";
    }
     ?>
    <legend>评论区</legend>
    <div class="row-fluid">
		<div class="span12">
			<form action="commentAction.php?id=<?php echo $id; ?>" method="post">
				<fieldset>
					 <label>请输入评论</label><input type="text" name="comment"/>
            <span class="help-block">请理性发言，维护网络环境从我做起。</span>
              <center> <button type="submit" class="btn">提交</button></center>
				</fieldset>
			</form>
		</div>
	</div><br><br><br><br><br>
  </div>
    <div class="col-md-3 column"></div>
	</div>
</div>
</body>
</html>
