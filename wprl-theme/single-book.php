<?
/*FILE: single-book.php
* DESCRIPTION: The template for displaying a single book
*/
//link to larger featured image
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
					$booklink = get_post_meta($post->ID, "wprl_link", true); 
					$cssstyle = 'margin: 0 0 100px '.$wprl_options['css_margin_left'].'%!important;'; ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="<? _e($cssstyle);?>">
				
						<h1 class="entry-title" id="entry-header"><?php the_title(); ?></h1>
						<div class="entry-content">
							<div class="entry-meta">
								<?php edit_post_link('Edit', '<span class="metaspan">', '</span>' );
									if ($wprl_options['show_author']) { ?>
										<span id="book-author" class="metaspan">By: <?php if ($authorlist = get_the_terms($post->ID, 'book-author'))
										foreach($authorlist as $author)
										{ ?>
											<a href="<?php _e(site_url());?>/book-author/<?php _e($author->name);?>"><?php _e($author->name);?></a>
										<? } ?>
										</span>
									<? }
									if ($wprl_options['show_page_nums'])
									{ ?>
										<span id="book-pages" class="metaspan">Pages: <?php _e(get_post_meta($post->ID,'wprl_pages',true));?></span>
									<? }
									if ($wprl_options['show_post_date'])
									{ ?>
											<span id="book-time" class="metaspan">Posted on: <?php _e(the_date()); ?></span>
									<? } 
									if ($wprl_options['post_author'])
									{ ?>
										<span id="post-author" class="metaspan">Posted by: <a href="<?php _e(site_url());?>/author/<?php _e(the_author_meta('user_nicename', $post->post_author));?>"><?php _e(the_author_meta('user_nicename', $post->post_author));?></a></span>
									<? } ?>								
							</div><!-- .entry-meta -->
							<?php if ($wprl_options['list_image']) 
								{
									if ($booklink && $wprl_options['show_url'])
									{
										_e('<a href="'.$booklink.'" target="_blank"/>');
									}
									if (has_post_thumbnail()) {
										the_post_thumbnail(array($cover_width, $cover_height), array(
											'id'	=> "post-thumbnail",
											'alt'	=> '',
										));
									}
									else{
										_e('<img id="post-thumbnail" src="'.$wprl_options['cover_image'].'" width="'.$cover_width.'" height="'.$cover_height.'">');
									}
									if ($booklink)
									{
										_e('</a>');
									} 
								} ?>
							<h2 id="single-title"><?php _e($wprl_options['title']);?></h2>
							<span id="the-content">
								<?php the_content(); ?>
							</span>
						</div><!-- .entry-content -->

					</article><!-- #post-<?php the_ID();?> -->
											
				<? } ?>
				<?php comments_template(); ?>
		<?php } 
		else{ ?>
			<h2 class="entry-header">No Results</h2>
		<? } ?>
	</div><!-- #content -->
</div><!-- #primary -->
<?php get_footer(); ?>