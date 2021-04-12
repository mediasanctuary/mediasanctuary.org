<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans+Condensed:ital,wght@0,300;0,400;1,400&family=Noto+Sans:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="<?php asset_url('dist/main.css'); ?>">
		<link rel="shortcut icon" href="<?php asset_url('img/favicon.ico'); ?>">
		<?php wp_head(); ?>
	</head>
	<body>
		<nav class="top-nav">
			<div class="container">
				<div class="logo"><a href="/"><img src="<?php asset_url('img/logo-720.png'); ?>" alt="The Sanctuary For Independent Media"></a></div>
				<div class="nav-link-container">
					<a href="#" class="nav-link nav-link--menu">Menu</a>
					<div class="nav-links">
						<a href="javascript:void(0);" class="nav-link">Events</a>
						<a href="javascript:void(0);" class="nav-link">Initiatives</a>

            <?php /* <a href="/events/" class="nav-link">Events</a>
						<a href="/initiatives/" class="nav-link">Initiatives</a> */?>

						<a href="/get-involved/" class="nav-link">Get Involved</a>
						<a href="/about/" class="nav-link">About</a>
					</div>
					<a href="/get-involved/donate/" class="nav-link nav-link--donate">Donate</a>
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
		<div class="header<?php echo is_front_page() ? ' home' : '';?>">
			<div class="container">
				<div class="header__items">
					<a href="http://stream.woocfm.org:8000/wooc" class="header__item header__item--wooc">
						<h3>WOOC 105.3 FM</h3>
						Listen Online
					</a>
					<a href="/sanctuary-tv/" class="header__item header__item--sanctuary-tv">
						<h3>Sanctuary TV</h3>
						Watch Online
					</a>
				</div>
				<form action="/" class="search">
					<input type="text" name="s" class="search-input" placeholder="Search">
					<button type="submit" class="search-button">
						<span class="visually-hidden">Search</span>
					</button>
				</form>
				
				
				<?php if(is_front_page()) {?>
				<div class="banner">
  				<div class="about">
            <p>We use art, science and participatory action to promote social and environmental justice and freedom of creative expression.</p>
  				</div>
  				<div class="callout">
    				<h2>CCG April Work Parties!</h2>
    				<span></span> 
    				<div> 				
      				<p>Join us (socially distanced, of course) to celebrate the spring together and clean up the CCG garden!</p>
      				<a href="" class="btn ironweed">Learn more</a>
    				</div>
  				</div>
				</div>
        <?php } ?>				
				
			</div>
		</div>
		<div id="content" class="main">
