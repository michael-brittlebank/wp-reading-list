<?php
/*FILE: list-archive-works.php
* DESCRIPTION: The template handler for displaying reading list archives
*/
$wprl_options = get_option('wprl_plugin_options');
$margin_left = $wprl_options['css_margin_left'];
get_header(); ?>
<div id="primary" class="content-area">
	<div id="content" class="site-content" role="main">
		<h1 class="entry-title" style="margin-left:<?php _e($margin_left)?>%!important;">
			<?php _e($wprl_options['multiple_title']);?>
		</h1>
		<?php if (have_posts()) 
		{
			if ($wprl_options['layout'] == 'grid')
			{
				$rows = $wprl_options['grid_rows'];
				$width = $wprl_options['grid_width'];
				$padding = $wprl_options['padding']/2;
				$width = $wprl_options['grid_width'];
				$i = 1;
				$metainfo = array(); 
				$post_counter = 0;
				while (have_posts())
				{
					the_post();
					$worklink = get_post_meta($post->ID, "wprl_link", true); 
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
							<?php if ($worklink && $wprl_options['show_url'])
							{
								_e('<a href="'.esc_url($worklink).'" target="_blank">');
							}
							if (has_post_thumbnail()) 
							{
								$image_src = wp_get_attachment_image_src(get_post_thumbnail_id(),'full');
								_e('<img src="'.esc_url($image_src[0]).'" style="width:100%;" />');
							}
							else{
								_e('<img src="'.esc_url($wprl_options['cover_image']).'"style="width:100%;">');
							}
							if ($worklink)
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
										<?php if($wprl_options['show_single_work'])
										{ ?>
											<a href="<?php _e(get_permalink($metapost->ID));?>">
										<?php } ?>
										<h2 class="entry-title">
										<?php _e(get_the_title($metapost->ID)); ?>
										</h2>									
										<?php if($wprl_options['show_single_work'])
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
															if ($wprl_options['show_author_link']) 
															{ ?>
																<a href="<?php _e(site_url());?>/reading-list/author/<?php _e($name);?>">
															<?php }
															_e(trim($author->name));
															if ($wprl_options['show_author_link'])
															{ ?>
																</a>
															<?php }														
															$j++;
														}
												}?></p>
										<?php }
										if ($wprl_options['show_page_nums'] && get_post_meta($post->ID,'wprl_pages',true))
										{ ?>
											<p id="work-pages">Pages: <?php _e(get_post_meta($metapost->ID,'wprl_pages',true));?></p>
										<?php } 
										if ($wprl_options['show_post_date'])
										{ ?>
											<p id="work-time">Posted on: <?php _e(get_the_time(get_option('date_format'), $metapost->ID)); ?></p>
										<?php } 
										if ($wprl_options['post_author'])
										{ ?>
											<p id="post-author">Posted by: <a href="<?php _e(site_url());?>/author/<?php _e(the_author_meta('user_nicename', $metapost->post_author));?>"><?php _e(the_author_meta('user_nicename', $metapost->post_author));?></a></p>
										<?php }
										if ($wprl_options['show_work_type'])
										{ ?>
											<p id="work-type"><?php
												if ($typelist = get_the_terms($metapost->ID, 'work-type'))
												{
												_e('Type: ');
												$j=1;
												$k=0;
												$numItems = count($typelist);
												foreach($typelist as $type)
													{	
														$name = str_replace(' ', '-', trim($type->name)) .'/';
														if (++$k === $numItems && $numItems != 1)
														{
															_e(' & ');
														}
														elseif ($j!=1)
														{
															_e(', ');
														}
														if ($wprl_options['show_type_link'])
														{ ?>
															<a href="<?php _e(site_url());?>/reading-list/type/<?php _e($name);?>">
														<?php }
														_e(trim($type->name));
														if ($wprl_options['show_type_link'])
														{ ?>
															</a>
														<?php }
													$j++;
													}
											}?></p>
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
				} 
			}
			else
			{
				$cover_width = $wprl_options['cover_width_grid'];
				$cover_height = $wprl_options['cover_height_grid'];
				$padding = $wprl_options['padding']/2;
				while (have_posts())
				{ 
					the_post(); 
					$worklink = get_post_meta($post->ID, "wprl_link", true); 
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
								if ($worklink && $wprl_options['show_url'])
								{
									_e('<a href="'.esc_url($worklink).'" target="_blank"/>');
								}
								if (has_post_thumbnail()) {
									the_post_thumbnail(array($cover_width , $cover_height));
								}
								else{
									_e('<img src="'.esc_url($wprl_options['cover_image']).'" width="'.$cover_width.'" height="'.$cover_height.'">');
								}
								if ($worklink && $wprl_options['show_url'])
								{
									_e('</a>');
								} 
							} ?></header>
						<div class="entry-meta">
							<?php if($wprl_options['show_single_work'])
							{ ?>
								<a href="<?php _e(the_permalink());?>">
							<?php } ?>
							<h2 class="entry-title"><?php _e(the_title());?></h2>
							<?php if($wprl_options['show_single_work'])
							{ ?>
								</a>
							<?php } 
							if ($wprl_options['show_list_excerpt'])
								{
									echo '<p class="wprl-excerpt">'.wprl_custom_excerpt(55).'</p>';
								}?>
							
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
															if ($wprl_options['show_author_link'])
															{ ?>
																<a href="<?php _e(site_url());?>/reading-list/author/<?php _e($name);?>">
															<?php }
															_e(trim($author->name));
															if ($wprl_options['show_author_link'])
															{ ?>
																</a>
															<?php }
														$j++;
														}
											}?></span>
										<?php } ?>
									</td>
									<td>
										<?php if ($wprl_options['show_post_date'] && get_the_date())
										{ ?>
											<span id="work-time">Posted on: <?php _e(get_the_date(get_option('date_format'))); ?></span>
										<?php } ?>	
									</td>
								</tr>
								<tr>
									<td>
										<?php if ($wprl_options['show_page_nums'] && get_post_meta($post->ID,'wprl_pages',true))
										{ ?>
											<span id="work-pages">Pages: <?php _e(get_post_meta($post->ID,'wprl_pages',true));?></span>
										<?php } ?>
									</td>
									<td>
										<?php if ($wprl_options['post_author'])
										{ ?>
											<span id="post-author">Posted by: <a href="<?php _e(site_url());?>/author/<?php _e(the_author_meta('user_nicename', $post->post_author));?>"><?php _e(the_author_meta('user_nicename', $post->post_author));?></a></span>
										<?php } ?>	
									</td>		
								</tr>
								<tr>
									<td>
										<?php if ($wprl_options['show_work_type'])
										{ ?>
											<span id="work-type">
											<?php if ($typelist = get_the_terms($post->ID, 'work-type'))
											{
												_e('Type: ');
												$j=1;
												$k=0;
												$numItems = count($typelist);
												foreach($typelist as $type)
													{	
														$name = str_replace(' ', '-', trim($type->name)) .'/';
														if (++$k === $numItems && $numItems != 1)
														{
															_e(' & ');
														}
														elseif ($j!=1)
														{
															_e(', ');
														}
														if ($wprl_options['show_type_link'])
														{ ?>
															<a href="<?php _e(site_url());?>/reading-list/type/<?php _e($name);?>">
														<?php }
														_e(trim($type->name));
														if ($wprl_options['show_type_link'])
														{ ?>
															</a>
														<?php }
													$j++;
													}
											}?></span>
										<?php } ?>	
									</td>
								</tr>
							</table>
						</div><!-- .entry-meta -->
					</article><!-- #post-<?php the_ID();?> -->
				<?php }
			}?>
			<nav class="navigation paging-navigation" role="navigation">
				<h1 class="screen-reader-text">Works navigation</h1>
				<div class="wprl-work-links nav-links" style="margin-left:<?php _e($wprl_options['css_margin_left'])?>%!important;">
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
