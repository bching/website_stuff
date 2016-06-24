<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link rel="stylesheet" href="/website_stuff/assets/css/menuStyle.css" type="text/css" />
	<title>Raw Uploads</title>
<body>
<?php include 'navi.php'; ?>

<?php 
echo $error;
$message = $this->session->flashdata();
if(!empty($message['flash_message'])){
	$html = '<p id="warning">';
	$html .= $message['flash_message'];
	$html .= '</p>';
	echo $html;
}
?>

<select id="upload_input_increase" class="dropdown" >
<?php
	echo "<option value='1' class='upload_clone' data-range='1' selected='selected'>1</option>";
	for($i = 2; $i < 11; $i++){
		echo "<option value='".$i."' class='upload_clone' data-range='2-10'>".$i."</option>";
	}
?>	
</select>

<script>
	document.addEventListener("DOMContentLoaded", function(event){
		console.log("DOM fully loaded and parsed.");

		var uploadInputCount = document.getElementById("upload_input_increase");
		uploadInputCount.addEventListener("change", alterUploadInput, false);
	});

	function alterUploadInput(){
		console.log("Trying to alter");
		if(this.value > 1){
			console.log("Value is greater than 1");
			var originalInput = document.getElementById("upload_form");
			var uploadArea= document.getElementById("upload_area");
			for(var i = 0; i < this.value; i++){
				var newInput = originalInput.cloneNode(true);
				uploadArea.appendChild(newInput);
			}
		}
	}
</script>

<?php echo form_open_multipart('raw_uploads/upload_text'); ?>
<div id="upload_area">
	<div class="upload_form" id="upload_form">
		<input type="file" name="raw_files[]" id="raw_files[]" multiple="multiple"/>
		<input type="submit" value="Upload" name="submit"/>
	</div>
</div>
</form>

<br/><br/>

<?php 
	echo '<ul>';
	foreach($files as $file => $file_name){
		$file_path = '';
		//$file_path .= "/". $file_dir_token ."/". $file_name;
		$file_path .= "/" . $file_name;
		$url = site_url() . '/raw_uploads/display_file' . $file_path;
		echo '<a href="'.$url.'">'.$file_name.'</a><br/>' ;
	}
	echo '</ul>';
?>
</body>
</html>
