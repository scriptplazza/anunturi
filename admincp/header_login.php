<?php 
session_start();
ob_start();

if(isset($_SESSION['adminuser'])){
	header("location:index.php");
}


include("../db.php");

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Flippy Classified - Admin Control Panel</title>
<meta name="author" content="FlippyScripts">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="favicon.ico" rel="shortcut icon" type="image/x-icon"/>

<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<script src="js/jquery.min.js"></script>	
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.pjax.js" type="text/javascript"></script>
<script src="js/jquery.ui.shake.js"></script>

<script>
$(function(){
  $(document).pjax('a', '.main-header');
});
</script>

</head>

<body>
<!--
  ______ _ _                    _____           _       _       
 |  ____| (_)                  / ____|         (_)     | |      
 | |__  | |_ _ __  _ __  _   _| (___   ___ _ __ _ _ __ | |_ ___ 
 |  __| | | | '_ \| '_ \| | | |\___ \ / __| '__| | '_ \| __/ __|
 | |    | | | |_) | |_) | |_| |____) | (__| |  | | |_) | |_\__ \
 |_|    |_|_| .__/| .__/ \__, |_____/ \___|_|  |_| .__/ \__|___/
            | |   | |     __/ |                  | |            
            |_|   |_|    |___/                   |_|            
-->
<div id="wrap">

<div class="container-fluid">

<header class="main-header">

<a class="logo" href="index.php"><img class="img-responsive" src="images/logo.png" alt="Flippy Admin Penal"></a>

</header>