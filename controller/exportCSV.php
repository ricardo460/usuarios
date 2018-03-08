<?php
$Name = $_GET["name"].'.csv';
$FileName = "./$Name";
header('Expires: 0');
header('Cache-control: private');
header('Content-Type: application/x-octet-stream;charset=utf-8'); // Archivo de Excel
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Content-Description: File Transfer');
header('Last-Modified: '.date('D, d M Y H:i:s'));
header('Content-Disposition: attachment; filename="'.$Name.'"');
header("Content-Transfer-Encoding: binary");

$head = json_decode(utf8_encode(base64_decode($_GET["data1"])));

$body = json_decode(utf8_encode(base64_decode($_GET["data2"])));

$data = "";

for($i = 0; $i < count($head); $i++){
	if($i === 0)
		$data .= $head[$i];
	else
		$data .= ";".$head[$i];
}

$data .= "\r\n";

for($i = 0; $i < count($body); $i++){

	for($l = 0; $l < count($body[$i]); $l++){
		$data .= $body[$i][$l].";";
	}

	$data .= "\r\n";
}

echo utf8_decode($data);

exit();
?>