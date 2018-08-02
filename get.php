<?php
	$data = $_POST['photo'];
	list($type, $data) = explode(';', $data);
	list(, $data)      = explode(',', $data);
	$data = base64_decode($data);
	mkdir(__DIR__."/images");
	file_put_contents(__DIR__."/images/image.png", $data);
	die;
?>
