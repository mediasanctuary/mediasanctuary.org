<div id="wooc" >
  	<div class="wooc">
      <figure><img src="<?php echo get_template_directory_uri(); ?>/img/sanctuary-radio-logo.png"/></figure>
      <div>
        <?php
          $radio = get_field('radio_section');
          if ($radio) {
            echo '<h3>'.$radio['heading'].'</h3>';
            echo '<p>'.$radio['description'].'</p>';
          } else {
            echo '<h3>Recently played on Sanctuary Radio <em>(broadcast on WOOC 105.3 FM Troy and streamed&nbsp;here)</em></h3>';
            echo '<p>We feature hard-hitting local news and international public affairs programming along with a multicultural mix of music from the Diaspora and beyond, including African pop, reggae, jazz and more.</p>';
          }  		
        ?>
      </div>
		</div>
		<div data-station="WOOC" data-action="now-playing-v2" data-merch="0" data-cover="0" data-sharing="0" data-player="0" data-num="4" class="spinitron-js-widget"></div>
		<script async src="//spinitron.com/static/js/widget.js"></script>
</div>

