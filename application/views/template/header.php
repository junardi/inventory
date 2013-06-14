<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" >
	<title>Inventory System</title>
	<link rel="shortcut icon" href="<?php echo base_url(); ?>images/favicon.ico" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>styles/style.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>styles/crud.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>styles/grid.css" />
</head>
<body>
	<div class="container clearfix">
		<div class="grid_12">
			<div id="header">
				<?php if(isset($interface) AND $interface == "login") { ?>
					<h1 class="left">Business Inventory</h1>
					<ul class="right">
						<li><a class="active" href="<?php echo base_url(); ?>index.php/login">Sign in</a></li>
					</ul>
					<div class="clear"></div>
				<?php } else { ?>
					<h1 class="left">Business Inventory</h1>
					<ul class="right">
						<li><a href="#">Maintenance</a></li>
						<li><a href="#">Account</a></li>
					</ul>
					<div class="clear"></div>
				<?php } ?>
			</div>
		</div>
	</div>