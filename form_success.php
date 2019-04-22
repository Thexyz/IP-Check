<!DOCTYPE html>
<html lang="en">

  <?php

  require_once('config.php');
  $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'N/A';
  $ip_forwarded = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : 'N/A';
  // create a log of everyone who comes here
  $ip_proxy = (($ip_forwarded === 'N/A') ? '' : 'Proxied from: '.$ip_forwarded);
  $referer = (($_SERVER['HTTP_REFERER']) ? ' ('.$_SERVER['HTTP_REFERER'].')': '');
  $myFile = "log";
  $fh = fopen($myFile, 'a');
  fwrite($fh, '['.date('Y-m-d H:i:s').'] '.$ip.' '.$ip_proxy.$referer.' has submitted their IP.'.PHP_EOL);

  fclose($fh);

  $name = $_GET['name'] ? htmlentities($_GET['name']) : '';
  $email = $_GET['email'] ? htmlentities($_GET['email']) : '';

  ?>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Eclarian">
    <link rel="icon" type="image/png" href="favicon.png">
    <title><?php echo $ip . (($ip_forwarded === 'N/A') ? '' : " - " . $ip_forwarded); ?></title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

    <!-- Custom styles for this template -->
    <link href="style.css" rel="stylesheet">
    <link href="custom_style.css" rel="stylesheet">
    <!-- Custom javascript for this template -->
    <script src="link_maker.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

    <div class="container">
      <div class="row">
        <div class="col-md-3"></div>
        <div class="">
        <div class="col-md-6">
          <a href="<?php echo IPConfig::logo_link; ?>" target="_blank">
          <img id="logo" src="<?php echo IPConfig::logo_url; ?>" alt="<?php echo IPConfig::logo_url; ?>" width="400">
          </a>
        </div>
        <div class="col-md-3"></div>
      </div>
      <div class="row">
      	<div class="col-md-2"></div>
      	<div class="col-md-12">
  	      <div class="starter-template">
  	        <!-- <h1><?php echo $ip; ?></h1> -->
  	        <?php if ($ip_forwarded !== 'N/A') : ?>
  	        	<!-- <p class="lead"><?php echo "Proxied from: ".$ip_forwarded; ?></p> -->
  	        <?php endif; ?>
            <h2 style="font-size: 46px;font-weight: bold;"><?php echo IPConfig::confirmation_header; ?></h2>
  	        <p class="lead"><?php echo IPConfig::confirmation_message; ?></p>
  	      </div>
    		</div>
        	<div class="col-md-2"></div>
    	</div>

    </div><!-- /.container -->

  </body>
</html>