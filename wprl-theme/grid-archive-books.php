<?
/*FILE: grid-archive-books.php
* DESCRIPTION: The template for displaying a list of books using the grid layout
*/

$wprl_options = get_option('wprl_plugin_options');
$rows = $wprl_options['grid_rows'];
$width = $wprl_options['grid_width'];
$cover_width = $wprl_options['cover_width_grid'];
$cover_height = $wprl_options['cover_height_grid'];
$padding = $wprl_options['padding']/2;
get_header(); ?>
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<h1 class="entry-header" style="margin-left:<? _e($wprl_options['css_margin_left'])?>%!important;"><?php _e($wprl_options['multiple_title']);?></h1>
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
					$post_counter++;
					if ($width == 2)
					{
						$cssstyle = 30;
					}
					elseif ($width == 3)
					{
						$cssstyle = 20;
					}
					elseif ($width == 4)
					{
						$cssstyle  = 10;
					}
					else
					{
						$cssstyle ='';
					} 
					if ($cssstyle)
					{
						$cssstyle = 'width:'.$cssstyle.'%;';
					}
					if ($i%$width == 1 || $i == 1) 
					{
					$cssstyle .= 'margin: 0 '.$padding.'px 0 '.$wprl_options['css_margin_left'].'%!important;';
					} 
					else
					{
					$cssstyle .= 'margin: 0 '.$padding.'px 0 '.$padding.'px!important;';
					}
					?>
					<article id="post-<?php the_ID(); ?>" style="<? _e($cssstyle);?>">
						<header class="entry-header">
							<? if ($booklink)
							{
								_e('<a href="'.$booklink.'" target="_blank"/>');
							}
							if (has_post_thumbnail()) {//todo check for post thumbnail support
								the_post_thumbnail(array($cover_width , $cover_height));
							}
							else{
								_e('<img src="'.$wprl_options['cover_image'].'" width="'.$cover_width.'" height="'.$cover_height.'">');
							}
							if ($booklink)
							{
								_e('</a>');
							} ?>
						</header><!-- .entry-header -->
					</article><!-- #post-<?php the_ID(); ?> -->
					<? if ($i%$width === 0 || $post_counter == count($posts))
					{
						$metainfo[] = get_post(); ?>
						<div class="spacer2">&nbsp;</div>
						<? foreach ($metainfo as $metapost)
						{
							?>
							<article id="post-<?php _e($metapost->ID);?>" class="meta-header" style="
							<? _e($cssstyle);
							if($metainfo[0] == $metapost)
							{
								_e('margin-left:'.$wprl_options['css_margin_left'].'%!important;'); 
							}?>
							">
								<header class="entry-header">
									<div class="entry-meta" style="width:<?php _e($cover_width);?>px;">
										<? if($wprl_options['show_book'])
										{ ?>
											<a href="<?php _e(get_permalink($metapost->ID));?>">
										<? } ?>
										<h2 class="entry-title" style="width:<?php _e($cover_width);?>px;">
										<?php _e(get_the_title($metapost->ID)); ?>
										</h2>									
										<? if($wprl_options['show_book'])
										{ ?>
											</a>
										<? }
										if ($wprl_options['show_author'])
										{ ?>
											<p id="book-author"><?php if ($authorlist = get_the_terms($metapost->ID, 'book-author'))
												{
													_e('By: ');
													foreach($authorlist as $author)
														{ ?>
															<a href="<?php _e(site_url());?>/book-author/<?php _e($author->name);?>"><?php _e($author->name);?></a>
														<? }
												}?></p>
										<? } ?>
										<? if ($wprl_options['show_page_nums'])
										{ ?>
											<p id="book-pages">Pages: <?php _e(get_post_meta($metapost->ID,'wprl_pages',true));?></p>
										<? } ?>
										<? if ($wprl_options['show_post_date'])
										{ ?>
											<p id="book-time">Posted on:<?php _e(get_the_date()); ?></p>
										<? } ?>
										<? if ($wprl_options['post_author'])
										{ ?>
											<p id="post-author">Posted by: <a href="<?php _e(site_url());?>/author/<?php _e(the_author_meta('user_nicename', $metapost->post_author));?>"><?php _e(the_author_meta('user_nicename', $metapost->post_author));?></a></p>
										<? } ?>			
									</div><!-- .entry-meta -->
								</header>
							</article><!-- #post-<?php _e($metapost->ID);?> -->
						<? }
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