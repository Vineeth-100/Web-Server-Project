<?php
declare(strict_types=1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login V2</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="<?= WEB_PAGES_DIR . "Vineeth/" ?>images/icons/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="<?= WEB_PAGES_DIR . "Vineeth/" ?>vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?= WEB_PAGES_DIR . "Vineeth/" ?>fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?= WEB_PAGES_DIR . "Vineeth/" ?>fonts/iconic/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="<?= WEB_PAGES_DIR . "Vineeth/" ?>vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="<?= WEB_PAGES_DIR . "Vineeth/" ?>vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="<?= WEB_PAGES_DIR . "Vineeth/" ?>vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="<?= WEB_PAGES_DIR . "Vineeth/" ?>vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="<?= WEB_PAGES_DIR . "Vineeth/" ?>vendor/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" type="text/css" href="<?= WEB_PAGES_DIR . "Vineeth/" ?>css/util.css">
	<link rel="stylesheet" type="text/css" href="<?= WEB_PAGES_DIR . "Vineeth/" ?>css/main.css">

</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form">
					<span class="login100-form-title p-b-26">
						Welcome
					</span>
					<span class="login100-form-title p-b-48">
						<i class="zmdi zmdi-font"></i>
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is: a@b.c">
						<input class="input100" type="text" name="email">
						<span class="focus-input100" data-placeholder="Email"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input class="input100" type="password" name="pass">
						<span class="focus-input100" data-placeholder="Password"></span>
					</div>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn">
								Login
							</button>
						</div>
					</div>

					<div class="text-center p-t-115">
						<span class="txt1">
							Don’t have an account?
						</span>

						<a class="txt2" href="#">
							Sign Up
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
	<script src="<?= WEB_PAGES_DIR . "Vineeth/" ?>vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="<?= WEB_PAGES_DIR . "Vineeth/" ?>vendor/animsition/js/animsition.min.js"></script>
	<script src="<?= WEB_PAGES_DIR . "Vineeth/" ?>vendor/bootstrap/js/popper.js"></script>
	<script src="<?= WEB_PAGES_DIR . "Vineeth/" ?>vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?= WEB_PAGES_DIR . "Vineeth/" ?>vendor/select2/select2.min.js"></script>
	<script src="<?= WEB_PAGES_DIR . "Vineeth/" ?>vendor/daterangepicker/moment.min.js"></script>
	<script src="<?= WEB_PAGES_DIR . "Vineeth/" ?>vendor/daterangepicker/daterangepicker.js"></script>
	<script src="<?= WEB_PAGES_DIR . "Vineeth/" ?>vendor/countdowntime/countdowntime.js"></script>
	<script src="<?= WEB_PAGES_DIR . "Vineeth/" ?>js/main.js"></script>

</body>
</html>