<?php
/*FILE: taxonomy-book-author.php
*DESCRIPTION: The template for displaying a taxonomy archives
*/
$value = get_queried_object();
get_header(); ?>
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<?php if ( have_posts() ){ ?>
				<header class="archive-header">
					<h1 class="archive-title">
						Archive for <?php _e($value->name);?>
					</h1>
				</header><!-- .archive-header -->
				<?php while (have_posts()) 
				{
					the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<header class="entry-header">
							<?php if ( has_post_thumbnail()) { ?>
									<?php the_post_thumbnail(array(200,267)); ?>
							<?php } ?>
							<h1 class="entry-title">
								<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
							</h1>
							<?php edit_post_link( __( 'Edit'), '<span class="edit-link">', '</span>' ); ?>
						</header><!-- .entry-header -->
						<div class="entry-summary">
							<?php the_excerpt(); ?>
						</div><!-- .entry-summary -->
				</article><!-- #post -->
				<?php } ?>
				<nav class="navigation paging-navigation" role="navigation">
					<h1 class="screen-reader-text">Books navigation</h1>
					<div class="wprl-book-links nav-links">
						<?php posts_nav_link(); ?>			
					</div><!-- .nav-links -->
				</nav>
			<?php }
			else{ ?>
				<h3 class="entry-header">No Results</h3>
			<?php } ?>
		</div><!-- #content -->
	</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>