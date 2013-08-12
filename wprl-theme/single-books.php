<?php
/**
 * The template for displaying a book
 *
 * @package Andrew Spittle
 * @since Andrew Spittle 1.0
 */
 
get_header(); ?>
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<?php if ( have_posts()) {
			//Start the loop
				while ( have_posts() ) : the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<header class="entry-header">
							<h1 class="entry-title"><?php the_title(); ?></h1>
							<div class="entry-meta">
								<p class="entry-author">
								<?php if ($terms = get_the_terms( $post->ID, 'book-author')){//TODO, make search by author
									$term_list = array_pop($terms)->name ;
									foreach( $terms as $os )
									{
										$term_list .= ", " . $os->name ;
									}
									echo 'By: ' . $term_list;}?>								
								</p>
							</div><!-- .entry-meta -->
						</header><!-- .entry-header -->
						<div class="entry-content">
							<?php 
							if (has_post_thumbnail()) { // check if the post has a Post Thumbnail assigned to it. ?>
								<a href="<?php echo esc_url(get_post_meta( $post->ID, 'wprl_link', true));?>" target="_blank">
							 	<?php the_post_thumbnail('book-cover');?>
								</a>
							<? }
							the_content();
							?>
						</div><!-- entry-content -->
					</article><!-- #post-<?php the_ID(); ?> -->

				<?php endwhile; 
			}
			else{
				get_template_part( 'no-results', 'index' );
			} ?>

			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->

<?php get_footer(); ?>