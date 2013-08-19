<?
/*FILE: grid-archive-books.php
* DESCRIPTION: The template for displaying a list of books using the grid layout
*/
//get full css reset

$wprl_options = get_option('wprl_plugin_options');
$rows = $wprl_options['grid_rows'];
$width = $wprl_options['grid_width'];
$cover_width = $wprl_options['cover_width_grid'];
$cover_height = $wprl_options['cover_height_grid'];

get_header(); ?>
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<h1 class="entry-header"><?php _e($wprl_options['multiple_title']);?></h1>
			<?php if (have_posts()) 
			{
				$i = 1;
				while (have_posts())
				{ 
					the_post(); 
					$booklink = get_post_meta($post->ID, "wprl_link", true); 
					$margin_left='';
					if ($i%2 != 0)
					{
					$margin_left='margin-left';
					}?>
					<article id="post-<?php the_ID(); ?>" class="<?php _e($margin_left);?>>
						<header class="entry-header">
							<? if ($booklink)
							{
								_e('<a href="'.$booklink.'" target="_blank"/>');
							}
							if (has_post_thumbnail()) {
								the_post_thumbnail(array($cover_width , $cover_height));
							}
							else{
								_e('<img src="'.plugins_url('wp-reading-list/wprl-theme/sample.png').'" width="'.$cover_width.'" height="'.$cover_height.'">');
							}
							if ($booklink)
							{
								_e('</a>');
							} ?>
							<h2 class="entry-title"><?php the_title(); ?></h2>
							<div class="entry-meta">
								<? if ($wprl_options['show_author'])
								{ ?>
									<p class="book-author">
										<?php if ($authorlist = get_the_terms($post->ID, 'book-author'))
										{
											$author_list = array_pop($authorlist)->name ;
											foreach($authorlist as $author)
												{
													$author_list .= ", " . $author->name ;
												}
											echo 'By: <a href="'.site_url().'/book-author/'.$author_list .'/">'.$author_list.'</a>';
										}?>
									</p>
								<? } ?>
								<? if ($wprl_options['show_post_date'])
								{ ?>
									<p class="book-time">
										Published On: 
										<?php _e(get_the_date()); ?>
									</p>
								<? } ?>
								<? if ($wprl_options['show_page_nums'])
								{ ?>
									<p class="book-pages">
											Pages: 
											<?php _e(get_post_meta($post->ID,'wprl_pages',true));?>
									</p>
								<? } ?>				
							</div><!-- .entry-meta -->
						</header><!-- .entry-header -->
					</article><!-- #post-<?php the_ID(); ?> -->
					<? if($i%$width === 0)
					{
						_e('<div class="spacer">&nbsp;</div>');
					}
					$i++;
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
<?php get_footer(); ?>