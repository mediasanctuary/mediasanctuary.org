<?php
/*
Template Name: Eco Art Trail
*/
?>
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
  <body <?php body_class(); ?>>
    <div id="content" class="main eco-art-trail">
      <section class="p40">
        <div class="container ">
          <article class="post post--single">
            <div class="content">
            <?php

            if (have_posts()) {
              while(have_posts()) {
                the_post();
                ?>
                <h1><?php the_title(); ?></h1>
                <?php the_content(); ?>
                <div class="eat-footer">
                  Part of the <a href="/project/sanctuary-eco-art-trail/">Sanctuary Eco-Art Trail</a>
                </div>
                <?php
              }
            } else {
              echo "Not found.";
            }

            ?>
            </div>
          </article>
        </div>
      </section>
      <?php wp_footer(); ?>
    </div>
  </body>
</html>