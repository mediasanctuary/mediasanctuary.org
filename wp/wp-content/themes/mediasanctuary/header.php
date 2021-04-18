<?php $events = (tribe_is_month() || tribe_is_event() || tribe_is_event_category() || tribe_is_in_main_loop() || tribe_is_view() || 'tribe_events' == get_post_type() || is_singular( 'tribe_events' )) ? true : false; ?>
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
					<ul class="nav-links">
						<li<?php echo ($events) ? ' class="active"' : '';?>><a href="/events/list/" class="nav-link">Events</a></li>
						<li<?php echo (is_page('initiatives') || is_page_template( 'page-templates/initiatives.php' )) ? ' class="active"' : '';?>><a href="/initiatives/" class="nav-link">Initiatives</a></li>
						<li<?php echo (is_page('get-involved')) ? ' class="active"' : '';?>><a href="/get-involved/" class="nav-link">Get Involved</a></li>
						<li<?php echo (is_page('about')) ? ' class="active"' : '';?>><a href="/about/" class="nav-link">About</a></li>
					</ul>
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
		
		
		<div class="header<?php echo is_front_page() ? ' home' : ''; echo (is_page('initiatives') || is_page_template( 'page-templates/initiatives.php')) ? ' initiative' : '';?>">
			<div class="container">
				
				
				<!-- Static -->
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
				
				
				<?php 
  				if(is_front_page()) { 
            $enabled = get_field('enable_callout') == 'enabled' ? ' showCallout' : false;
            $callout = get_field('callout');
  		  ?>
				<div class="banner<?php echo $enabled; ?>">
  				<div class="about">
            <p>We use art, science and participatory action to promote social and environmental justice and freedom of creative expression.</p>
            <a href="/about/" class="btn ironweed">Learn more About Us</a>            
  				</div>
  				
  				<?php if( $enabled ) { ?> 
  				<div class="callout">
    				<h2><?php echo $callout['text']['heading']?></h2>
    				<?php if($callout['callout_image']){ ?>
    				  <a href="<?php echo esc_url($callout['button']['callout_url']);?>">
    				    <span style="background-image: url(<?php echo esc_attr($callout['callout_image']); ?>);"></span>
    				  </a>
    				<?php } ?>
    				<div> 				
      				<p><?php echo $callout['text']['description'];?></p>
      				<a href="<?php echo esc_url($callout['button']['callout_url']);?>" class="btn ironweed"><?php echo $callout['button']['callout_button_text'] ? $callout['button']['callout_button_text'] : 'Learn More';?></a>
    				</div>
  				</div>
  				<?php } ?>  				
  				
				</div>
        <?php } ?>	
        
        <?php 
  				if(is_page() && !is_front_page()) {
    				if(is_page_template( 'page-templates/initiatives.php')) {
              $logo = get_field('initiative_logo');
              if($logo){
                echo '<img src="'.$logo.'" class="initiative-logo"/>';
              } else {
                echo '<h1>'.get_the_title().'</h1>';	                
              }

    				} else {
    			    echo '<h1>'.get_the_title().'</h1>';	
    			  }
    		  }
    		?> 
        
        			
				
			</div>
		</div>
		
		
		
		<div id="content" class="main">
