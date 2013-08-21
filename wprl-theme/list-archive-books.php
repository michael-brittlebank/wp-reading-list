<?
/*FILE: list-archive-books.php
* DESCRIPTION: The template for displaying books using the list layout
*/

$wprl_options = get_option('wprl_plugin_options');
$cover_width = $wprl_options['cover_width_grid'];
$cover_height = $wprl_options['cover_height_grid'];
$padding = $wprl_options['padding']/2;
get_header(); ?>
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<h1 class="entry-header" style="margin-left:<? _e($wprl_options['css_margin_left'])?>%!important;"><?php _e($wprl_options['multiple_title']);?></h1>
			<?php if (have_posts()) 
			{
				while (have_posts())
				{ 
					the_post(); 
					$booklink = get_post_meta($post->ID, "wprl_link", true); 
					$cssstyle = 'margin: 0 '.$padding.'px 0 '.$wprl_options['css_margin_left'].'%!important;';
					$liststyle = 'max-width:'.$cover_width.'px!important;margin-bottom:'.$wprl_options['padding'].'px!important;';
					if($wprl_options['list_image'])
					{
						$liststyle .= 'display: inline-block!important;';
					}
					else
					{
						$liststyle .= 'display: none!important;';
					}
					?>
					<article id="post-<?php the_ID(); ?>" style="<? _e($cssstyle);?>">
						<header class="entry-header" style=" <?php _e($liststyle);?>"><? 
							if ($wprl_options['list_image']) 
							{
								if ($booklink && $wprl_options['show_url'])
								{
									_e('<a href="'.$booklink.'" target="_blank"/>');
								}
								if (has_post_thumbnail()) {
									the_post_thumbnail(array($cover_width , $cover_height));
								}
								else{
									_e('<img src="'.$wprl_options['cover_image'].'" width="'.$cover_width.'" height="'.$cover_height.'">');
								}
								if ($booklink)
								{
									_e('</a>');
								} 
							} ?></header>
						<div class="entry-meta">
							<? if($wprl_options['show_book'])
							{ ?>
								<a href="<?php _e(the_permalink());?>">
							<? } ?>
							<h2 class="entry-title"><?php _e(the_title());?></h2>
							<? if($wprl_options['show_book'])
							{ ?>
								</a>
							<? } ?>
							<table>
								<tr>
									<td>
										<? if ($wprl_options['show_author'])
										{ ?>
											<span id="book-author"><?php if ($authorlist = get_the_terms($post->ID, 'book-author'))
											{
												_e('By: ');
												foreach($authorlist as $author)
												{ ?>
													<a href="<?php _e(site_url());?>/book-author/<?php _e($author->name);?>"><?php _e($author->name);?></a>
												<? }
											}?></span>
										<? } ?>
									</td>
									<td>
										<? if ($wprl_options['show_post_date'])
										{ ?>
											<span id="book-time">Posted on: <?php _e(the_date()); ?></span>
										<? } ?>	
									</td>

								</tr>
								<tr>
									<td>
										<? if ($wprl_options['show_page_nums'])
										{ ?>
											<span id="book-pages">Pages: <?php _e(get_post_meta($post->ID,'wprl_pages',true));?></span>
										<? } ?>
									</td>
									<td>
										<? if ($wprl_options['post_author'])
										{ ?>
											<span id="post-author">Posted by: <a href="<?php _e(site_url());?>/author/<?php _e(the_author_meta('user_nicename', $post->post_author));?>"><?php _e(the_author_meta('user_nicename', $post->post_author));?></a></span>
										<? } ?>	
									</td>
																		
								</tr>
							</table>
						</div><!-- .entry-meta -->
					</article><!-- #post-<?php the_ID();?> -->
				<? } ?>
				<nav class="navigation paging-navigation" role="navigation">
					<h1 class="screen-reader-text">Books navigation</h1>
					<div class="wprl-book-links nav-links" style="margin-left:<? _e($wprl_options['css_margin_left'])?>%!important;">
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