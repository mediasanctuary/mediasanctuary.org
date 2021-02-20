<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width">
		<link rel="stylesheet" href="<?php asset_url('dist/main.css'); ?>">
		<link rel="shortcut icon" href="<?php asset_url('img/favicon.ico'); ?>">
		<?php wp_head(); ?>
	</head>
	<body>
		<nav class="top-nav">
			<div class="container">
				<h1 class="logo"><a href="/"><img src="<?php asset_url('img/logo-720.png'); ?>" alt="The Sanctuary For Independent Media"></a></h1>
				<div class="nav-link-container">
					<a href="#" class="nav-link nav-link--menu">Menu</a>
					<div class="nav-links">
						<a href="/events/" class="nav-link">Events</a>
						<a href="/initiatives/" class="nav-link">Initiatives</a>
						<a href="/get-involved/" class="nav-link">Get Involved</a>
						<a href="/about/" class="nav-link">About</a>
					</div>
					<a href="/get-involved/give/donate/" class="nav-link nav-link--donate">Donate</a>
				</div>
			</div>
			<div class="mobile-menu">
				<div class="container">
					The Sanctuary for Independent Media
					<div class="close-menu">&times;</div>
					<div class="nav-links">
						<a href="/" class="nav-link">Home</a>
						<a href="/events/" class="nav-link">Events</a>
						<a href="/initiatives/" class="nav-link">Initiatives</a>
						<a href="/get-involved/" class="nav-link">Get Involved</a>
						<a href="/about/" class="nav-link">About</a>
					</div>
					<a href="/get-involved/give/donate/" class="nav-link nav-link--donate">Donate</a>
				</div>
			</div>
		</nav>
		<div class="header">
			<div class="container">
				<div class="header__items">
					<a href="http://stream.woocfm.org:8000/wooc" class="header__item header__item--wooc">
						<h3>WOOC 105.3 FM</h3>
						Listen Online
					</a>
					<a href="/sanctuary-tv/" class="header__item header__item--sanctuary-tv">
						<h3>Sanctuary TV</h3>
						Streaming Live!
					</a>
				</div>
				<form action="/" class="search">
					<input type="text" name="s" class="search-input" placeholder="Search">
					<button type="submit" class="search-button">
						<span class="visually-hidden">Search</span>
					</button>
				</form>
			</div>
		</div>
		<div id="content" class="main">
