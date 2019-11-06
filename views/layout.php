<!DOCTYPE html>
<html lang="en">
	<head>
		<base href="/localhost" />
		<meta charset="UTF-8" />
		<title><?= $title ?></title>
		<link rel="stylesheet" href="/public/style.css" type="text/css"/>
		<link href="https://fonts.googleapis.com/css?family=Pacifico|Roboto&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	</head>
	<body>
		<?php foreach ($messages as $message) : ?>
			<p class="message"><?= $message ?></p>
		<?php endforeach ?>
		<div id="nav_bar">
			<header id="logo"><a href="Gallery">Camagru</a></header>

			<?php if($_SESSION['username']):?>
				<div class="dropdown">
					<button class="dropbtn" id="newpost">New Post</button>
					<div class="dropdown-content">
						<a href="Newpost/Upload">Upload a Picture</a>
						<a href="Newpost/Webcam">Take a Picture</a>
					</div>
				</div>
			<?php endif?>

			<ul id="nav">
				<?php if(!$_SESSION['username']):?>
					<li><a href="Login">Login</a></li>
					<li><a href="Register">Register</a></li>
				<?php elseif($_SESSION['username']):?>
					<li>Welcome, <?=$_SESSION['username']?></li>
					<li><a href="Gallery/user_gallery/<?=$_SESSION['id_user']?>">My Gallery</a></li>
					<li><a href="modify/my_profile">My Account</a></li>
					<li><a href="Logout">Logout</a></li>
			</ul>			
			<?php endif?>
		</div>
		
		<div class="page-content">
			<?php $this->controller->renderView();?>
		</div>

		<footer>
			<hr />
            42 CAMAGRU © lpan 2019
		</footer>
	</body>
</html>
