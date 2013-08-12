<?
/*FILE: archive-books.php
* DESCRIPTION: The template for displaying a list of 'books'
*/
get_header(); ?>
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<h1 class="entry-title">Recently Read</h1>
			<?php if (have_posts()) {
				while (have_posts()){
					the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'book-column' );//TODO ?>>
						<?php 
							if (has_post_thumbnail()) { ?>
							 	<a href="<?php get_post_meta($post->ID,'wprl_link',true)?>" target="_blank"/>
								<?php the_post_thumbnail( 'book-cover' );
								echo ('</a>');
							}
						?>
						<header class="entry-header">
							<h1 class="entry-title"><?php the_title(); ?></h1>
							<div class="entry-meta">
								<p class="entry-author">
								<?php if ($terms = get_the_terms( $post->ID, 'book-author')){
									$term_list = array_pop($terms)->name ;
									foreach( $terms as $os )
									{
										$term_list .= ", " . $os->name ;
									}
									echo 'By: ' . $term_list;}?>								
								</p>
							</div><!-- .entry-meta -->
						</header><!-- .entry-header -->
					</article><!-- #post-<?php the_ID(); ?> -->
				<?php } ?>
				<div id="books-nav-link"><?php posts_nav_link(); ?></div>
			<?php }
			else{
				get_template_part('no-results', 'index');

			} ?>
			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->
<?php get_footer(); ?>