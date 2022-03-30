<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Donovan
 */

// Check if Sidebar has widgets.
if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	<section id="secondary" class="sidebar widget-area clearfix" role="complementary">
		<div id="block-21" class="sidebar widget-area clearfix">
			<div class="wp-block-group">
				<?php get_search_form(); ?>
			</div>
		</div>
		<div id="block-22" class="widget-area clearfix">
			<div class="wp-block-group">
				<h2><?php get_field('edit_listing_title'); the_field('edit_listing_title'); ?></h2>
				<p>
					<?php get_field('help_from'); the_field('help_from'); ?>
				</p>
			</div>
		</div>
		<div id="block-23" class="widget-area clearfix">
			<div class="wp-block-group">
				<h2><?php the_title(); ?> Contact Info</h2>
				<div class="contact_info">
					<?php get_field('contact_info'); the_field('contact_info'); ?>
				</div>
			</div>
		</div>
		<div id="block-28" class="widget-area clearfix">
			<div class="wp-block-group">
				<h2><?php the_title(); ?> Business Type</h2>
				<div class="contact_info">
				<?php if ( function_exists( 'wp_tag_cloud' ) ) : ?>
					<?php wp_tag_cloud( 'smallest=8&largest=22' ); ?>
				<?php endif; ?>
				</div>
			</div>
		</div>
		<div id="block-24" class="widget-area clearfix">
			<div class="wp-block-group">
				<h2><?php get_field('more_company_title'); the_field('more_company_title') ?></h2>
				<div class="more_company_info">
					<?php get_field('more_company_info'); the_field('more_company_info'); ?>
				</div>
			</div>
		</div>
		<div id="block-26" class="widget-area clearfix">
	    <div class="wp-block-group">
	    <h2>OPENING HOURS</h2>
	    <?php echo do_shortcode('[mbhi_hours location="America-NYC"]'); ?>
	    </div>
	</div>
		<div id="block-25" class="widget-area clearfix">
			<div class="wp-block-group">
				<h2><?php get_field('news_title'); the_field('news_title') ?></h2>
				<div class="news_info "><?php get_field('news_info'); the_field('news_info'); ?></div>
			</div>
		</div>
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</section><!-- #secondary -->
<?php
endif;