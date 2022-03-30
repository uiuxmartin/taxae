<?php
/**
 * The template for displaying single posts
 *
 * @package Donovan
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php donovan_post_image_single(); ?>

	<div class="post-content">

		<header class="entry-header">

			<h1 class="entry-title"> <?php the_title(); echo " "; get_field('tfn'); the_field('tfn'); ?></h1> 
           
<?php donovan_entry_footer(); ?>
			<?php donovan_entry_meta(); ?>

		</header><!-- .entry-header -->
        <div class="breadcrumb">
           <ul itemscope itemtype="https://schema.org/BreadcrumbList" style="list-style-type:none;">
                  <li itemprop="itemListElement" itemscope
                     itemtype="https://schema.org/ListItem" style="display:inline; ">
                     <a itemtype="https://schema.org/Thing"
                        itemprop="item"
                        href="https://taxae.com/">
                     <span itemprop="name">Taxae</span></a>
                     <meta itemprop="position" content="1" />
                  </li>
                  » 
                   
                  <li itemprop="itemListElement" itemscope
                     itemtype="https://schema.org/ListItem" style="display:inline; ">
                     <a itemtype="https://schema.org/Thing"
                        itemprop="item"
                        href="<?php echo get_permalink(); ?>">
                     <b itemprop="name"><?php the_title(); ?></b></a>
                     <meta itemprop="position" content="3" />
                  </li>
			   </ul>
        </div>
		<div class="entry-content clearfix">
<div class="row">
     <div class="col-md-6"><?php the_content(); ?></div>
    <div class="col-md-6"><?php get_field('other_info_table'); the_field('other_info_table'); ?></div>
</div>
		

			<?php wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'donovan' ),
				'after'  => '</div>',
			) ); ?>

		</div><!-- .entry-content -->

		<?php do_action( 'donovan_author_bio' ); ?>

	</div><!-- .post-content -->

	<footer class="entry-footer post-details">
		<?php donovan_entry_footer(); ?>
	</footer><!-- .entry-footer -->

</article>
