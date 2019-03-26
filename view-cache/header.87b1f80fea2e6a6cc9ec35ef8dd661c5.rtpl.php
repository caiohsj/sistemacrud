<?php if(!class_exists('Rain\Tpl')){exit;}?><!DOCTYPE html>
<html>
<head>
	<title>Sistema CRUD</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="/css/bootstrap.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<div class="container">
		<nav class="navbar navbar-dark bg-dark mb-4">


  			<span class="navbar-brand mb-0 h1"><?php echo htmlspecialchars( $usuario["nome"], ENT_COMPAT, 'UTF-8', FALSE ); ?></span>
  			<a class="navbar-brand mb-0 h1" href="/sair">Sair</a>
		</nav>