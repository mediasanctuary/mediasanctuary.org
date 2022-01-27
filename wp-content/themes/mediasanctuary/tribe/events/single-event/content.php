<?php
/**
 * Single Event Content Template Part
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/single-event/content.php
 *
 * See more documentation about our Blocks Editor templating system.
 *
 * @link http://evnt.is/1aiy
 *
 * @version 4.7
 *
 */
?>

<?php $event_id = $this->get( 'post_id' ); ?>
<div id="post-<?php echo absint( $event_id ); ?>" <?php post_class(); ?>>
<div class="post--single">
  <ul class="social event top">
    <li><strong>Share</strong></li>
    <li><a href="http://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink(); ?>" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=550,height=450,left=30,top=50');return false;" class="fb">Facebook</a></li>
    <li><a href="http://twitter.com/share?text=<?php echo get_the_title(); ?>&url=<?php echo get_permalink(); ?>&via=mediasanctuary" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=550,height=450,left=30,top=50');return false;" class="tw">Twitter</a></li>
    <li><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo get_permalink(); ?>&title=<?php echo get_the_title(); ?>&summary=<?php echo strip_tags(get_the_excerpt());?>&source=mediasanctuary.org" target="_blank" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=550,height=450,left=30,top=50');return false;" class="ln">LinkedIn</a></li>
    <li><a href="mailto:?subject=Article from the Sanctuary for Independent Media&body=Hi, this may be interesting to you: &ldquo;<?php echo get_the_title(); ?>&rdquo;! View the event: <?php echo get_permalink(); ?>" class="em">E-mail</a></li>
  </ul>
</div>
<?php tribe_the_content( null, false, $event_id ); ?>
</div>
