<?php get_header(); ?>
<section class="p30">
	<div class="container">
			<?php
			if(have_posts()) : while(have_posts()) : the_post(); 
			    echo '<h1>'; the_title(); echo '</h1>';
		    	the_content();
		    endwhile; endif;
		    ?>
	</div>
</section>
<?php get_footer(); ?>