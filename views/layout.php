<!DOCTYPE html>
<html lang="en">
	<head>
		<base href="/localhost" />
		<meta charset="UTF-8" />
		<title><?= $title ?></title>
		<meta name="description" content="<?= $description ?>" />
		<link rel="stylesheet" href="style.css" type="text/css"/>
	</head>

	<body>
		<header>
			<h1>Camagru</h1>
		</header>
		<?php foreach ($messages as $message) : ?>
			<p class="message"><?= $message ?></p>
		<?php endforeach ?>

		<a href="Login">Login</a>
		<a href="Register">Register</a>

		<article>
			<?php $this->controller->renderView();?>
		</article>

		<footer>
			<hr />
            © lpan 2019
		</footer>
	</body>
</html>