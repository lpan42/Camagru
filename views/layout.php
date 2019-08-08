<!DOCTYPE html>
<html lang="en">
	<head>
		<base href="/localhost" />
		<meta charset="UTF-8" />
		<title><?= $title ?></title>
		<link rel="stylesheet" href="/public/style.css" type="text/css"/>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	</head>

	<body>
		<header>
			<h1><a href="gallery">Camagru</h1>
		</header>
		<?php foreach ($messages as $message) : ?>
			<p class="message"><?= $message ?></p>
		<?php endforeach ?>

		<?php if(!$_SESSION['username']):?>
			<a href="Login">Login</a>
			<a href="Register">Register</a>
		<?php elseif($_SESSION['username']):?>
			Welcome, <?=$_SESSION['username']?><br/>
			<div>
				<button>My account</button>
				<div>
					<a href="modify/password">Change Password</a>
					<a href="modify/email-prefer">Email Preference</a>
				</div>
			</div> 
			<a href="Logout">Logout</a>
		<?php endif?>
		<p>
			<?php $this->controller->renderView();?>
		</p>

		<footer>
			<hr />
            © lpan 2019
		</footer>
	</body>
</html>