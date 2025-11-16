<?php
/**
 * Block: Event Links
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/blocks/event-links.php
 *
 * See more documentation about our Blocks Editor templating system.
 *
 * @link http://evnt.is/1aiy
 *
 * @version 4.7
 *
 */

// don't show on password protected posts
if ( post_password_required() ) {
	return;
}

$has_google_cal = $this->attr( 'hasGoogleCalendar' );
$has_ical       = $this->attr( 'hasiCal' );
$should_render  = $has_google_cal || $has_ical;

if ( ! $should_render ) {
	return;
}

remove_filter( 'the_content', 'do_blocks', 9 );
$subscribe_links = empty( $this->context['subscribe_links'] ) ? false : $this->context['subscribe_links'];

if ( $has_google_cal ) {
	$google_cal_link = $subscribe_links ? $subscribe_links[ 'gcal' ]->get_uri( null ) : Tribe__Events__Main::instance()->esc_gcal_url( tribe_get_gcal_link() );
}

if ( $has_ical ) {
	if ( empty( $subscribe_links ) ) {
		$ical_link = tribe_get_single_ical_link();
	} else if ( ! empty( $subscribe_links[ 'ical' ] ) ) {
		$ical_link = $subscribe_links[ 'ical' ]->get_uri( null );	
	}
}

?>

<div class="tribe-block tribe-block__events-link">

	<div class="post--single">
		<ul class="social event">
			<li><strong>Share</strong></li>
			<li><a href="http://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink(); ?>" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=550,height=450,left=30,top=50');return false;" class="fb">Facebook</a></li>
			<li><a href="http://twitter.com/share?text=<?php echo get_the_title(); ?>&url=<?php echo get_permalink(); ?>&via=mediasanctuary" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=550,height=450,left=30,top=50');return false;" class="tw">Twitter</a></li>
			<li><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo get_permalink(); ?>&title=<?php echo get_the_title(); ?>&summary=<?php echo strip_tags(get_the_excerpt());?>&source=mediasanctuary.org" target="_blank" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=550,height=450,left=30,top=50');return false;" class="ln">LinkedIn</a></li>
			<li><a href="mailto:?subject=Article from the Sanctuary for Independent Media&body=Hi, this may be interesting to you: &ldquo;<?php echo get_the_title(); ?>&rdquo;! View the event: <?php echo get_permalink(); ?>" class="em">E-mail</a></li>
		</ul>
	</div>

	<?php if ( $has_google_cal ) : ?>
		<div class="tribe-block__btn--link tribe-block__events-gcal">
			<a
				href="<?php echo esc_url( $google_cal_link ); ?>"
				target="_blank"
				rel="noopener noreferrer nofollow"
				title="<?php esc_attr_e( 'Add to Google Calendar', 'the-events-calendar' ); ?>"
			>
				<img src="<?php echo Tribe__Main::instance()->plugin_url  . 'src/modules/icons/link.svg'; ?>" />
				<?php echo esc_html( $this->attr( 'googleCalendarLabel' ) ) ?>
			</a>
		</div>
	<?php endif; ?>
	<?php if ( $has_ical ) : ?>
		<div class="tribe-block__btn--link tribe-block__-events-ical">
			<a
				href="<?php echo esc_url( $ical_link ); ?>"
				rel="noopener noreferrer nofollow"
				title="<?php esc_attr_e( 'Add to iCalendar', 'the-events-calendar' ); ?>"
			>
				<img src="<?php echo Tribe__Main::instance()->plugin_url  . 'src/modules/icons/link.svg'; ?>" />
				<?php echo esc_html( $this->attr( 'iCalLabel' ) ) ?>
			</a>
		</div>
	<?php endif; ?>
</div>

<?php add_filter( 'the_content', 'do_blocks', 9 );
