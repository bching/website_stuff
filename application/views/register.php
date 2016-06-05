<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>User Registration</title>
</head>
<body>
<h1>New User</h1>
<?php echo validation_errors(); ?>
<?php echo form_open('register/registerUser'); ?>
	<fieldset>
		<legend>Registration</legend>
		<div class='row'>
			<label for="firstName">First Name:</label>
			<input type="text" size="25" id="firstName" name="firstName"/>
			<label for="lastName">Last Name:</label>
			<input type="text" size="25" id="lastName" name="lastName"/>
		</div>
		<div class='row'>
			<label for="email">Email:</label>
			<input type="text" size="25" id="email" name="email"/>
		</div>
		<div class='container'>
			<input type="submit" value="Register"/>
		</div>
	</fieldset>
</body>
</html>
