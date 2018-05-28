<?php
session_start();
unset($_SESSION['name']);
unset($_SESSION['id']);
unset($_SESSION['email']);
echo "<script>alert('注销成功');history.go('-1');location.reload();</script>";
 ?>
