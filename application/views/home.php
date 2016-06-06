<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<style>
	ul {
		list-style-type: none;
		margin: 0;
		padding: 0;
		overflow: hidden;
		background-color: #333;
	}

	li {
		float: left;
		border-right:1px solid #bbb;
	}

	li:last-child {
		border-right: none;
	}

	li a {
		display: block;
		color: white;
		text-align: center;
		padding: 14px 16px;
		text-decoration: none;
	}

	li a:hover:not(.active) {
		background-color: #111;
	}

	.active {
		background-color: $4CSF50;
	}
	</style>

	<title>Home Page</title>
</head>
<body>
	<h1>Home</h1>
	<h2>Welcome <?php echo $firstName; ?></h2><br/>
	<ul>
		<li><a href="<?php echo site_url(); ?>/raw">Raw Uploads</a></li>
		<li><a href="preprocess">Preprocessed Uploads</a></li>
		<li><a href="semantic">Semantic Networks</a></li>
		<li><a href="home_ctrl">Logout</a></li>
	</ul>
</body>
</html>
