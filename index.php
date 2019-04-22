<!DOCTYPE html>
<html lang="en">
<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
?>

  <?php
  // Check if config.php exists
  if (file_exists('install.php')) {
    // echo "install";
  	// config does not exist, redirect to install.php
  	require_once('install.php');
  	die();
  }
  // echo "config";
  // Load Config
  require_once('config.php');


  $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'N/A';
  $ip_forwarded = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : 'N/A';
  // create a log of everyone who comes here
  $ip_proxy = (($ip_forwarded === 'N/A') ? '' : 'Proxied from: '.$ip_forwarded);
  $referer = (($_SERVER['HTTP_REFERER']) ? ' ('.$_SERVER['HTTP_REFERER'].')': '');
  $myFile = "log";
  $fh = fopen($myFile, 'a');
  fwrite($fh, '['.date('Y-m-d H:i:s').'] '.$ip.' '.$ip_proxy.$referer.PHP_EOL);

  fclose($fh);

  $name = $_GET['name'] ? htmlentities($_GET['name']) : '';
  $email = $_GET['email'] ? htmlentities($_GET['email']) : '';
  $error = $_GET['error'] ? n2lbr(htmlentities($_GET['error'])) : '';

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

    <!-- Googe Analytics Code -->
    <?php if (IPConfig::hasAnalytics()) { ?>
          <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', '<?php echo IPConfig::ga_code; ?>', 'auto');
            ga('send', 'pageview');
          </script>
    <?php } ?>

    <div class="container">
    	<div class="row">
	    	<div class="col-md-3"></div>
    		<div class="col-md-6">
    			<a href="<?php echo IPConfig::logo_link; ?>" target="_blank">
    			<img id="logo" src="<?php echo IPConfig::logo_url; ?>" alt="<?php echo IPConfig::company; ?>" width="100%">
    			</a>
    		</div>
	    	<div class="col-md-3"></div>
    	</div>

	    <div class="row">
	    	<div class="col-md-3"></div>
	    	<div class="col-md-6">
		      <div class="starter-template">
		        <h1><?php echo $ip; ?></h1>
		        <?php if ($ip_forwarded !== 'N/A') : ?>
		        	<p class="lead"><?php echo "Proxied from: ".$ip_forwarded; ?></p>
		        <?php endif; ?>
		        <p class="lead">The above is your IP address. Fill out the form below and it will send your message to support with your IP address.</p>
		      	<?php if (!empty($error)) : ?>
		      		<p class="lead text-danger"><?php echo $error; ?></p>
		      	<?php endif; ?>
		      </div>
			</div>
	    	<div class="col-md-3"></div>
		</div>

	    <div class="row">
	    	<div class="col-md-3"></div>
	    	<div class="col-md-6">
			    <form method="post" action="handle_form.php" role="form">
			    	<div class="form-group">
			    		<input type="hidden" name="ip_form" value="submitted">
						<input type="hidden" name="ip" value="<?php echo $ip; ?>">
						<input type="hidden" name="ip_forwarded" value="<?php echo $ip_forwarded; ?>">
						Name *<br /><input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" required autofocus><br />
						Email *<br /><input type="text" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required><br />
						Message (optional)<br />
						<textarea name="message" class="form-control"></textarea>
					</div>
			    	<div class="form-group">
						<input type="submit" class="btn btn-info btn-block" value="<?php echo IPConfig::submit_text; ?>">
						<br />
						<span class="config_input_note">Admins Can Use This Button To Create A Link To Send To Users</span><br />
			    		<button type="button" class="btn btn-default copy-button" title="Copy Form Submission URL">
							<span class="glyphicon glyphicon-list-alt"></span>
						</button><br />
					</div>
				</form>
			</div>
	    	<div class="col-md-3"></div>
		</div>

	</div><!-- /.container -->

  </body>
</html>