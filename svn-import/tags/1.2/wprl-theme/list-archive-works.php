<?php
/*FILE: list-archive-works.php
* DESCRIPTION: The template for displaying reading list items using the list layout
*/

$wprl_options = get_option('wprl_plugin_options');
$cover_width = $wprl_options['cover_width_grid'];
$cover_height = $wprl_options['cover_height_grid'];
$padding = $wprl_options['padding']/2;
get_header(); ?>
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<h1 class="entry-title" style="margin-left:<?php _e($wprl_options['css_margin_left'])?>%!important;"><?php _e($wprl_options['multiple_title']);?></h1>
			<?php if (have_posts()) 
			{
				while (have_posts())
				{ 
					the_post(); 
					$booklink = get_post_meta($post->ID, "wprl_link", true); 
					$cssstyle = 'margin: 0 '.$padding.'px 0 '.$wprl_options['css_margin_left'].'%!important;';
					$liststyle = 'max-width:'.$cover_width.'px!important;';
					if ($wp_query->current_post == 0 && !is_paged())
					{
						$liststyle .= 'margin:0 0 '.$padding.'% 0!important;';
					}
					else
					{
						$liststyle .=	'margin:'.$padding.'% 0 '.$padding.'% 0!important;';
					}
					if($wprl_options['list_image'])
					{
						$liststyle .= 'display: inline-block!important;';
					}
					else
					{
						$liststyle .= 'display: none!important;';
					}
					?>
					<article id="post-<?php the_ID(); ?>" style="<?php _e($cssstyle);?>">
						<header class="entry-header" style=" <?php _e($liststyle);?>"><?php 
							if ($wprl_options['list_image']) 
							{
								if ($booklink && $wprl_options['show_url'])
								{
									_e('<a href="'.esc_url($booklink).'" target="_blank"/>');
								}
								if (has_post_thumbnail()) {
									the_post_thumbnail(array($cover_width , $cover_height));
								}
								else{
									_e('<img src="'.esc_url($wprl_options['cover_image']).'" width="'.$cover_width.'" height="'.$cover_height.'">');
								}
								if ($booklink && $wprl_options['show_url'])
								{
									_e('</a>');
								} 
							} ?></header>
						<div class="entry-meta">
							<?php if($wprl_options['show_book'])
							{ ?>
								<a href="<?php _e(the_permalink());?>">
							<?php } ?>
							<h2 class="entry-title"><?php _e(the_title());?></h2>
							<?php if($wprl_options['show_book'])
							{ ?>
								</a>
							<?php } ?>
							<table>
								<tr>
									<td>
										<?php if ($wprl_options['show_author'])
										{ ?>
											<span id="work-author"><?php if ($authorlist = get_the_terms($post->ID, 'work-author'))
											{
												_e('By: ');
													$j=1;
													$k=0;
													$numItems = count($authorlist);
													foreach($authorlist as $author)
														{	
															$name = str_replace(' ', '-', trim($author->name)) .'/';
															if (++$k === $numItems && $numItems != 1)
															{
																_e(' & ');
															}
															elseif ($j!=1)
															{
																_e(', ');
															}
															if ($wprl_options['author_link'])
															{ ?>
																<a href="<?php _e(site_url());?>/work-author/<?php _e($name);?>">
															<?php }
															_e(trim($author->name));
															if ($wprl_options['author_link'])
															{ ?>
																</a>
															<?php }
														$j++;
														}
											}?></span>
										<?php } ?>
									</td>
									<td>
										<?php if ($wprl_options['show_post_date'])
										{ ?>
											<span id="book-time">Posted on: <?php _e(the_date()); ?></span>
										<?php } ?>	
									</td>
								</tr>
								<tr>
									<td>
										<?php if ($wprl_options['show_page_nums'] && get_post_meta($post->ID,'wprl_pages',true))
										{ ?>
											<span id="book-pages">Pages: <?php _e(get_post_meta($post->ID,'wprl_pages',true));?></span>
										<?php } ?>
									</td>
									<td>
										<?php if ($wprl_options['post_author'])
										{ ?>
											<span id="post-author">Posted by: <a href="<?php _e(site_url());?>/author/<?php _e(the_author_meta('user_nicename', $post->post_author));?>"><?php _e(the_author_meta('user_nicename', $post->post_author));?></a></span>
										<?php } ?>	
									</td>		
								</tr>
							</table>
						</div><!-- .entry-meta -->
					</article><!-- #post-<?php the_ID();?> -->
				<?php } ?>
				<nav class="navigation paging-navigation" role="navigation">
					<h1 class="screen-reader-text">Books navigation</h1>
					<div class="wprl-book-links nav-links" style="margin-left:<?php _e($wprl_options['css_margin_left'])?>%!important;">
						<?php posts_nav_link(); ?>			
					</div><!-- .nav-links -->
				</nav>
		<?php } 
		else{ ?>
			<h3 class="entry-header">No Results</h3>
		<?php } ?>
	</div><!-- #content -->
</div><!-- #primary -->
<?php get_footer(); ?>