<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>SDX no Fansub</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1">
	<link rel="stylesheet" href="/css/normalize.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="/admin/css/new-style.css" type="text/css" media="screen" />
	<link rel="icon" href="/favicon.ico" type="image/x-icon" />
	<script src="/js/modernizr-2.5.3.min.js"></script>
	<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script src='/google_analytics_auto.js'></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script src="/js/cpanel.capitulos.js"></script>
</head>
<body class="contenedor">
	<figure id="riasimagen">
		<img src="/img/rias/<?php
$rias = rand(1,6);
if ($rias==1) {
	echo "banador";
}
elseif ($rias==2) {
	echo "conejita";
}
elseif ($rias==3) {
	echo "delantal";
}
elseif ($rias==4) {
	echo "deportiva";
}
elseif ($rias==5) {
	echo "uniforme1";
}
elseif ($rias==6) {
	echo "uniforme2";
}
?>.png">
	</figure>
	<header>
		<h1>SDX no Fansub</h1>
	</header>
