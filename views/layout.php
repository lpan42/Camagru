<!DOCTYPE html>
<html lang="en">
	<head>
		<base href="/localhost" />
		<meta charset="UTF-8" />
		<title><?= $title ?></title>
		<link rel="stylesheet" href="/public/style.css" type="text/css"/>
	</head>

	<body>
		<header>
			<h1>Camagru</h1>
		</header>
		<?php foreach ($messages as $message) : ?>
			<p class="message"><?= $message ?></p>
		<?php endforeach ?>

		<?php if(!$_SESSION['username']):?>
			<a href="Login">Login</a>
			<a href="Register">Register</a>
		<?php elseif($_SESSION['username']):?>
			Welcome, <?=$_SESSION['username']?><br/>
			<a >My account</a><br/>
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