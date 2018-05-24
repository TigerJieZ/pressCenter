<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400">  <!-- Google web font "Open Sans" -->
<head>
    <meta charset="UTF-8">
    <title>新闻管理</title>
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
						<li class="active">
							<a href="manageNews.php">管理新闻</a>
						</li>
            <li>
							<a href="manageComments.php">管理评论</a>
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
			<table class="table">
				<thead>
					<tr>
						<th>
							编号
						</th>
						<th>
							标题
						</th>
						<th>
							日期
						</th>
						<th>
					操作
					</th>
					</tr>
				</thead>
				<tbody>
          <?php
          $connect = mysqli_connect('localhost','root','','press') or die('Unale to connect');
      		if (!$connect)
       		{
      			die('Could not connect: ' . mysql_error());
      		}
      		//查询单条数据并以json的格式输出
      		$sql = "select * from news;";
      		// 执行sql语句返回结果集
      		$result = mysqli_query($connect,$sql);

      		while($row = mysqli_fetch_array($result))
      		{
            echo "<tr>";
            echo "<td>";
            echo $row['id'];
            echo "</td>";
            echo "<td>";
            echo $row['title'];
            echo "</td>";
            echo "<td>";
            echo $row['date'];
            echo "</td>";
            echo "<td><td>";
            echo "<form action=\"editNews.php?Gid=";
            echo $row['id'];
            echo "\" method=\"POST\"><button type=\"submit\" class=\"btn btn-default\">编辑</button></form></td>";
            echo "<td><form action=\"deleteAction.php?Gid=";
            echo $row['id'];
            echo "\" method=\"POST\"><button type=\"submit\" class=\"btn btn-default\">删除</button></form></td></td>";
          }
           ?>
				</tbody>
			</table>
		</div>
	</div>
	</div>
	</body>
	</html>
