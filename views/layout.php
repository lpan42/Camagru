<!DOCTYPE html>
<html lang="en">
	<head>
		<base href="/localhost" />
		<meta charset="UTF-8" />
		<title><?= $title ?></title>
		<link rel="stylesheet" href="/public/style.css" type="text/css"/>
		<link href="https://fonts.googleapis.com/css?family=Pacifico|Roboto&display=swap" rel="stylesheet">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	</head>
	<body>
		<?php foreach ($messages as $message) : ?>
			<p class="message"><?= $message ?></p>
		<?php endforeach ?>
		<div id="nav_bar">
			<header id="logo"><a href="Gallery">Camagru</a></header>
			<ul id="nav">
				<?php if(!$_SESSION['username']):?>
					<li><a href="Login">Login</a></li>
					<li><a href="Register">Register</a></li>

				<?php elseif($_SESSION['username']):?>
				<li>Welcome, <?=$_SESSION['username']?></li>
					<div class="dropdown">
					<li class="dropbtn" id ="my_account">My account</li>
						<div class="dropdown-content">
						<a href="modify/password">Change Password</a>
						<a href="modify/email-prefer">Email Preference</a>
						</div>
					</div>
					<li><a href="Logout">Logout</a></li>
			</ul>			

			<div class="dropdown">
				<button class="dropbtn" id="newpost">New Post</button>
				<div class="dropdown-content">
					<a href="Newpost/Upload">Upload a Picture</a>
					<a href="Newpost/Webcam">Take a Picture</a>
				</div>
			</div>
			<?php endif?>
		</div>
		<div class="page-content">
			<?php $this->controller->renderView();?>
		</div>

		<!-- <footer>
			<hr />
            © lpan 2019
		</footer> -->
	</body>
</html>