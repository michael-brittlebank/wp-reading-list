<?php



/*FILE: taxonomy-work-type.php



*DESCRIPTION: The template for displaying a work type archive



*/



$value = get_queried_object();



$wprl_options = get_option('wprl_plugin_options');



$postCount = 1;



get_header(); ?>


<section id="wprl-section">
	<div id="primary" class="content-area">



		<div id="content" class="site-content" role="main">



			<?php if ( have_posts() ){ ?>



				<header class="archive-header">



					<h1 class="archive-title">



						<?php _e('Archive for', 'wp_reading_list');  echo (' '.$value->name);?>



					</h1>



				</header><!-- .archive-header -->



				<?php while (have_posts()) 



				{



					the_post(); 



					$worklink = get_post_meta($post->ID, "wprl_link", true);  ?>



					<article id="post-<?php the_ID(); ?>" 



					<?php post_class();



					if ($postCount == sizeof($posts))



					{



						echo ('style="margin-bottom:50px!important;"');



					}



					?>



					>



						<header class="entry-header">



						<?php if ($wprl_options['list_image']) 



								{



									if ($worklink && $wprl_options['show_url'])



									{



										echo ('<a id="post-thumbnail" href="'.esc_url($worklink).'" target="_blank"/>');



									}



									if (has_post_thumbnail()) {



										the_post_thumbnail(array(200,267));



									}



									else{



										echo ('<img src="'.esc_url($wprl_options['cover_image']).'" width="200" height="267">');



									}



									if ($worklink)



									{



										echo ('</a>');



									} 



								} ?>



							<h1 class="entry-title">



								<?php if($wprl_options['show_single_work'])



								{ ?>



									<a href="<?php the_permalink(); ?>" rel="bookmark">



								<?php }



								the_title(); 



								if($wprl_options['show_single_work'])



								{ ?>



									</a>



								<?php } ?>



							</h1>



							<?php edit_post_link( __( 'Edit'), '<span class="edit-link">', '</span>' ); ?>



							<div class="entry-summary">



								<?php echo '<p class="wprl-excerpt">'.wprl_custom_excerpt(110).'</p>'; ?>



							</div><!-- .entry-summary -->



					</header><!-- .entry-header -->



				</article><!-- #post -->



				<?php 



				$postCount++;



				} ?>



				<nav class="navigation paging-navigation" role="navigation">



					<h1 class="screen-reader-text">Works navigation</h1>



					<div class="wprl-work-links nav-links">



						<?php posts_nav_link(); ?>			



					</div><!-- .nav-links -->



				</nav>



			<?php }



			else{ ?>



				<h3 class="entry-header"><?php _e('No Results', 'wp_reading_list');?></h3>



			<?php } ?>



		</div><!-- #content -->



	</div><!-- #primary -->

</section>

<?php get_sidebar(); ?>



<?php get_footer(); ?>



