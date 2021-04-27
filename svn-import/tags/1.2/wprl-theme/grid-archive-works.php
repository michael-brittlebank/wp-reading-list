<?php
/*FILE: grid-archive-works.php
* DESCRIPTION: The template for displaying reading list items using the grid layout
*/

$wprl_options = get_option('wprl_plugin_options');
$rows = $wprl_options['grid_rows'];
$width = $wprl_options['grid_width'];
$padding = $wprl_options['padding']/2;
$width = $wprl_options['grid_width'];
$margin_left = $wprl_options['css_margin_left'];
get_header(); ?>
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<h1 class="entry-title" style="margin-left:<?php _e($margin_left)?>%!important;"><?php _e($wprl_options['multiple_title']);?></h1>
			<?php if (have_posts()) 
			{
				$i = 1;
				$metainfo = array(); 
				$post_counter = 0;
				while (have_posts())
				{
					the_post();
					$booklink = get_post_meta($post->ID, "wprl_link", true); 
					$cssstyle = '';
					$widthstyle = '';
					$post_counter++;
					if ($width == 1 || $i%$width == 1 || $i == 1) 
					{
					$cssstyle = 'margin: 0 '.$padding.'% 0 '.$margin_left.'%!important;';
					}
					else
					{
					$cssstyle = 'margin: 0 '.$padding.'% 0 '.$padding.'%!important;';
					}
					if ($width == 2)
					{
						$widthstyle = 47-$margin_left/2-$padding*2;
					}
					elseif ($width == 3)
					{
						$widthstyle = 32-$margin_left/3-$padding*2;
					}
					elseif ($width == 4)
					{
						$widthstyle = 24-$margin_left/4-$padding*2;
					}
					$cssstyle .= 'width:'.$widthstyle.'%;';
					?>
					<article id="post-<?php the_ID(); ?>" style="<?php _e($cssstyle);?>">
						<header class="entry-header">
							<?php if ($booklink && $wprl_options['show_url'])
							{
								_e('<a href="'.esc_url($booklink).'" target="_blank">');
							}
							if (has_post_thumbnail()) 
							{
								$image_src = wp_get_attachment_image_src(get_post_thumbnail_id(),'full');
     								_e('<img src="'.esc_url($image_src[0]).'" style="width:100%;" />');
							}
							else{
								_e('<img src="'.esc_url($wprl_options['cover_image']).'"style="width:100%;">');
							}
							if ($booklink)
							{
								_e('</a>');
							} ?>
						</header><!-- .entry-header -->
					</article><!-- #post-<?php the_ID(); ?> -->
					<?php if ($i%$width === 0 || $post_counter == count($posts))
					{
						$metainfo[] = get_post(); ?>
						<div class="spacer2">&nbsp;</div>
						<?php foreach ($metainfo as $metapost)
						{
							?>
							<article id="post-<?php _e($metapost->ID);?>" class="meta-header" style="
							<?php _e($cssstyle);
							if($metainfo[0] == $metapost)
							{
								_e('margin-left:'.$margin_left.'%!important;'); 
							}?>
							">
								<header class="entry-header">
									<div class="entry-meta">
										<?php if($wprl_options['show_book'])
										{ ?>
											<a href="<?php _e(get_permalink($metapost->ID));?>">
										<?php } ?>
										<h2 class="entry-title">
										<?php _e(get_the_title($metapost->ID)); ?>
										</h2>									
										<?php if($wprl_options['show_book'])
										{ ?>
											</a>
										<?php }
										if ($wprl_options['show_author'])
										{ ?>
											<p id="work-author"><?php if ($authorlist = get_the_terms($metapost->ID, 'work-author'))
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
												}?></p>
										<?php } ?>
										<?php if ($wprl_options['show_page_nums'] && get_post_meta($post->ID,'wprl_pages',true))
										{ ?>
											<p id="book-pages">Pages: <?php _e(get_post_meta($metapost->ID,'wprl_pages',true));?></p>
										<?php } ?>
										<?php if ($wprl_options['show_post_date'])
										{ ?>
											<p id="book-time">Posted on: <?php _e(get_the_time(get_option('date_format'), $metapost->ID)); ?></p>
										<?php } ?>
										<?php if ($wprl_options['post_author'])
										{ ?>
											<p id="post-author">Posted by: <a href="<?php _e(site_url());?>/author/<?php _e(the_author_meta('user_nicename', $metapost->post_author));?>"><?php _e(the_author_meta('user_nicename', $metapost->post_author));?></a></p>
										<?php } ?>			
									</div><!-- .entry-meta -->
								</header>
							</article><!-- #post-<?php _e($metapost->ID);?> -->
						<?php }
						_e('<div class="spacer">&nbsp;</div>');
						unset($metainfo);
					}
					else
					{
						$metainfo[] = get_post();
					}
					$i++;
				} ?>
				<nav class="navigation paging-navigation" role="navigation">
					<h1 class="screen-reader-text">Books navigation</h1>
					<div class="wprl-book-links nav-links" style="margin-left:<?php _e($margin_left)?>%!important;">
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