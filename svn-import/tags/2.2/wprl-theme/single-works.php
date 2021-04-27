<?php

/*FILE: single-work.php

* DESCRIPTION: The template for displaying a single reading list item

*/



$wprl_options = get_option('wprl_plugin_options');

$cover_width = '200';

$cover_height = '276';

get_header(); ?>

	<div id="primary" class="content-area">

		<div id="content" class="site-content" role="main">

			<?php if (have_posts()) 

			{

				while (have_posts())

				{ 

					the_post(); 

					$worklink = get_post_meta($post->ID, "wprl_link", true);  ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >

						<h1 class="entry-header" id="entry-header"><?php the_title(); ?></h1>

						<div class="entry-content">

							<div class="entry-meta">

									<?php if ($wprl_options['show_author']) { ?>

										<span id="work-author" class="metaspan"><?php _e('By: ', 'wp_reading_list'); if ($authorlist = get_the_terms($post->ID, 'work-author')){

													$j=1;

													$k=0;

													$numItems = count($authorlist);

													foreach($authorlist as $author)

														{	

															$name = str_replace(' ', '-', trim($author->name)) .'/';

															if (++$k === $numItems && $numItems != 1)

															{

																echo(' & ');

															}

															elseif ($j!=1)

															{

																echo(', ');

															}

															if ($wprl_options['show_author_link'])

															{ ?>

																<a href="<?php echo(site_url());?>/reading-list/author/<?php echo($name);?>">

															<?php }

															echo(trim($author->name));

															if ($wprl_options['show_author_link'])

															{ ?>

																</a>

															<?php }

															$j++;

														}

													} ?>

										</span>

									<?php }

									if ($wprl_options['show_page_nums'] && get_post_meta($post->ID,'wprl_pages',true))

									{ ?>

										<span id="work-pages" class="metaspan"><?php _e('Pages: ', 'wp_reading_list'); echo(get_post_meta($post->ID,'wprl_pages',true));?></span>

									<?php }

									if ($wprl_options['show_post_date'])

									{ ?>

											<span id="work-time" class="metaspan"><?php _e('Posted on: ', 'wp_reading_list'); echo(the_date()); ?></span>

									<?php } 

									if ($wprl_options['post_author'])

									{ ?>

										<span id="post-author" class="metaspan"><?php _e('Posted By: ', 'wp_reading_list');?> <a href="<?php echo(site_url());?>/author/<?php echo(the_author_meta('user_nicename', $post->post_author));?>"><?php echo(the_author_meta('user_nicename', $post->post_author));?></a></span>

									<?php }	

								edit_post_link('Edit', '<span class="metaspan">', '</span>' );	?>							

							</div><!-- .entry-meta -->

							<?php if ($wprl_options['list_image']) 

								{

									if ($worklink && $wprl_options['show_url'])

									{

										echo('<a href="'.esc_url($worklink).'" target="_blank"/>');

									}

									if (has_post_thumbnail()) {

										the_post_thumbnail(array($cover_width, $cover_height), array(

											'id'	=> "post-thumbnail",

											'alt'	=> '',

										));

									}

									else{

										echo('<img id="post-thumbnail" src="'.esc_url($wprl_options['cover_image']).'" width="'.$cover_width.'" height="'.$cover_height.'">');

									}

									if ($worklink)

									{

										echo('</a>');

									} 

								} ?>

							<h2 id="single-title"><?php echo($wprl_options['title']);?></h2>

							<span id="the-content">

								<?php the_content(); ?>

							</span>

						</div><!-- .entry-content -->

					</article><!-- #post-<?php the_ID();?> -->

				<?php } 

				comments_template(); 

				} 

		else{ ?>

			<h2 class="entry-header"><?php _e('No Results: ', 'wp_reading_list');?></h2>

		<?php } ?>

	</div><!-- #content -->

</div><!-- #primary -->

<?php get_sidebar(); 

get_footer();