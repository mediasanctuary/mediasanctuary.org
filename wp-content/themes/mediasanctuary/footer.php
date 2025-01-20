		</div>
		
    <?php include get_template_directory() . '/sections/section-newsletter.php';?>		
		
    <section id="about">
      <div class="container">
        <div class="two-col">
          
          <div class="col w45">
            <div class="initiatives">
              <img src="<?php asset_url('img/Sanctuary-White-Black-Shadow.svg'); ?>" alt="" />
              <ul>                
                <?php
                  $args = array(
                    'post_type' => 'page',
                    'post_parent'=> 29640,
                    'orderby' => 'title',
                    'order' => 'ASC'
                  );
                  $queryInitiatives = new WP_Query($args);
                  if ($queryInitiatives->have_posts()) :
                      while ($queryInitiatives->have_posts()) : $queryInitiatives->the_post();?>
                        <li>
                          <a href="<?php echo get_permalink();?>">
                            <?php the_title();?>
                          </a>
                        </li>
                      <?php endwhile;
                  endif;
                  wp_reset_query();
                ?>
              </ul> 
            </div>           
          </div>

          <div class="col w55">
            <h2>About The Sanctuary</h2>
            <p>We use art and participatory action to promote social and environmental justice and freedom of creative expression.</p>
            <a href="/about/" class="btn">Learn More</a>
            <ul class="social">
              <li><a href="https://www.facebook.com/mediasanctuary" target="_blank" class="fb">Facebook</a></li>
    					<li><a href="https://www.instagram.com/mediasanctuary" target="_blank" class="ig">Instagram</a></li>
    					<li><a href="https://www.youtube.com/channel/UC5JTfy24J7STy5lwDeNHq6g" target="_blank" class="yt">YouTube</a></li>
    					<li><a href="https://www.linkedin.com/company/mediasanctuary" target="_blank" class="in">LinkedIn</a></li>
    					<li><a href="https://soundcloud.com/mediasanctuary" target="_blank" class="sc">SoundCloud</a></li>
    					<li><a href="https://open.spotify.com/user/woocfm" target="_blank" class="spotify">Spotify</a></li>
        		</ul>
          </div>

        </div>
      </div>
    </section>		
		
		<footer>
  		<div class="container">
        <div class="two-col">  
          <div class="col w45">      		
            <p>The Sanctuary for Independent Media is a project of <strong>Media Alliance Inc</strong>, a <a href="https://www.guidestar.org/profile/11-2538804" target="_blank">501c(3) non-profit organization</a> located at 3361 6th Avenue in North Troy, New&nbsp;York.&nbsp;&nbsp;&bull;&nbsp;&nbsp;EIN 11-2538804. Donations are tax-deductible.<br/>P.O. Box 35 Troy,&nbsp;NY 12181&nbsp;&nbsp;&bull;&nbsp;&nbsp;<a href="/contact/">Contact Us</a>
          </div>
          <div class="col w55">									      		
            <p>Over the years our programs have been made possible by the National Endowment for the Arts, the NY State Council on the Arts with the support of the office of the Governor and the NY State Legislature, NYS Department of Environmental Conservation, local and national foundations, and <a href="https://www.mediasanctuary.org/get-involved/donate/">Sanctuary Sustainers</a>. See a full list of our <a href="https://www.mediasanctuary.org/about/supporters/">supporters and friends</a>.</p>
              <ul class="sponsors">
                <li><img src="<?php asset_url('img/sponsors/nea.jpg'); ?>" alt="National Endowment for the Arts"></li>
                <li><img src="<?php asset_url('img/sponsors/nysca.jpg'); ?>" alt="New York State Council on the Arts"></li>
                <li><img src="<?php asset_url('img/sponsors/dec.jpg'); ?>" alt="New York State Department of Environmental Conservation"></li>
                <li><img src="<?php asset_url('img/sponsors/community.jpg'); ?>" alt="The Community Foundation for the Greater Capital Region"></li>
                <li><img src="<?php asset_url('img/sponsors/iear2.jpg'); ?>" alt="iEAR Presents!"></li>
                <li><img src="<?php asset_url('img/sponsors/stewarts.jpg'); ?>" alt="Stewart’s Shops"></li>
              </ul>
            </p>
          </div>
        </div>
      </div>
		</footer>
		
		<?php wp_footer(); ?>
		
	</body>
</html>
