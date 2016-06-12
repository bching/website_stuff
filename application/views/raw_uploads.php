<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link rel="stylesheet" href="/website_stuff/assets/css/menuStyle.css" type="text/css" />
	<title>Raw Uploads</title>
<body>
	<?php include 'navi.php'; ?>
<?php 
	//$files = scandir($file_dir);
	echo '<ul>';
	foreach($files as $file => $file_name){
		$file_path = '';
		$file_path .= "/". $file_dir_token ."/". $file_name;
		$url = site_url() . '/raw_uploads/display_file' . $file_path;
		//$file_handle = fopen($file_dir, "r");
		echo '<a href="'.$url.'">'.$file_name.'</a><br/>' ;
	}
	echo '</ul>';
	?>
</body>
</html>
