<?php

$url= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
//1 鐢╬arse_url瑙ｆ瀽URL,姝ゅ鏄�$str
$arr = parse_url($url);


//2 灏哢RL涓殑鍙傛暟鍙栧嚭鏉ユ斁鍒版暟缁勯噷
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
    <title>鏌ユ壘鏂伴椈</title>
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
						<li >
							<a href="searchNews.php">查找新闻</a>
						</li>
            <li >
              <a href="manageNews.php">管理新闻</a>
            </li>
            <?php session_start();
            if (isset($_SESSION['permission'])){
              if($_SESSION['permission']==1){
                echo "
                <li>
    							<a href=\"manageComments.php\">管理评论</a>
    						</li>";
              }
            }
             ?>
            <li class="active">
							<a href="manageComments.php">新闻详情</a>
						</li>
					</ul>
					<form class="navbar-form navbar-right" role="search" action="searchNews.php" method="POST">
            <?php
              if(isset($_SESSION['id'])){
              echo $_SESSION['name'];
              echo "&emsp;&emsp;<a href=\"logout.php\">注销</a>";
            }else{
              echo "<a href=\"login.php\">登录</a>";
              echo "&emsp;&emsp;&emsp;";
              echo "<a href=\"register.php\">注册</a>";
            }?>
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
$connect = mysqli_connect('10.18.33.86','H_Z09415124','sujie1997','h_z09415124') or die('Unale to connect');
        mysqli_query($connect,"set names utf8");
				if (!$connect)
				{
					die('Could not connect: ' . mysql_error());
				}
				//锟斤拷询锟斤拷锟斤拷锟斤拷锟捷诧拷锟斤拷json锟侥革拷式锟斤拷锟�
				$sql = "select * from news where ID =$id";
				// 执锟斤拷sql锟斤拷浞碉拷亟锟斤拷锟斤拷
				$result = mysqli_query($connect,$sql);

				while($row = mysqli_fetch_array($result))
				{
					echo "<div class=\"col-md-6 column\"><center><h2>";
					echo $row['title'];
					echo "</h2></center><p>";
					// 锟斤拷取锟斤拷锟斤拷
					$context_name=$row['context'];
					$myfile = fopen($context_name, "r") or die("Unable to open file!");
					echo fread($myfile,filesize($context_name));
					fclose($myfile);
					echo "</p>";
				}
			}else{
				echo "璇疯緭鍏ヨ璇勮鐨勬柊闂籌D";
			}

		} catch (Exception $e) {
			echo "璇疯緭鍏ヨ璇勮鐨勬柊闂籌D";
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
      echo "&emsp;&emsp;&emsp;";
      $commentsID=$row['id'];
      $sql="SELECT userID from comments_user where commentsID= $commentsID";
      $result_u = mysqli_query($connect,$sql);
      while($row_u=mysqli_fetch_array($result_u)){
        $userID=$row_u['userID'];
      }
      $sql="SELECT name from user where id=$userID";
      $result_n = mysqli_query($connect,$sql);
      while($row_n=mysqli_fetch_array($result_n)){
        echo $row_n['name'];
      }
      echo "</div>";
      echo "<legend> </legend><br><br>";
    }
     ?>
    <legend>评论区</legend>
    <div class="row-fluid">
		<div class="span12">
			<form action="commentAction.php?id=<?php echo $id; ?>" method="post">
				<fieldset>
					 <label>新闻评论</label><input type="text" name="comment"/>
            <span class="help-block">维护良好的网络社区环境，从我做起！</span>
              <center> <button type="submit" class="btn">发表</button></center>
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
