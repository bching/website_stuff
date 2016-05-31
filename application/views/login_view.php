<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999.xhtml">
<head>
	<title>UAA NLP Login</title>
</head>
<body>
	<h1>NLP Tools Login</h1>
	<?php echo validation_errors(); ?>
	<?php echo form_open('verifylogin'); ?>

		<fieldset>
			<legend>Login</legend>
			<div class='container'>
				<label for="username">Username:</label><br/>
				<input type="text" size="20" id="username" name="username"/>
			</div>
			<div class='container'>
				<label for="password">Password:</label><br/>
				<input type="password" size="20" id="password" name="password"/>
			</div>
			<div class='container'>
				<input type="submit" value="Login"/>
			</div>
		</fieldset>
