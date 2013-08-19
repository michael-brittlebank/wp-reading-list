<?
/*FILE: taxonomy-book-author.php
*DESCRIPTION: The template for displaying a taxonomy archives
*/
//todo !!!complete!!!
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
					the_post();
					get_template_part('content', get_post_format());
				} ?>
				<nav class="navigation paging-navigation" role="navigation">
					<h1 class="screen-reader-text">Books navigation</h1>
					<div class="wprl-book-links nav-links">
						<?php posts_nav_link(); ?>			
					</div><!-- .nav-links -->
				</nav>
			<?php }
			else{ ?>
				<h3 class="entry-header">No Results</h3>
			<? } ?>
		</div><!-- #content -->
	</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>