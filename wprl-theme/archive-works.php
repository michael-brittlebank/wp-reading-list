<?php
/*FILE: list-archive-works.php
* DESCRIPTION: The template handler for displaying reading list archives
*/
require 'render-work.php';
$wprl_options = get_option('wprl_plugin_options');
get_header();

?>
    <main id="wprl-container" role="main">
        <h1 class="wprl-title">
            <?php echo($wprl_options['multiple_title']); ?>
        </h1>
        <section class="wprl-full-screen-grid-container wprl-archive-container">
            <?php if (have_posts()) {?>
                <div class="wprl-row">
                    <?php $posts = $wp_query->found_posts;
                    $rows = $wprl_options['grid_rows'];
                    $width = $wprl_options['grid_width'];
                    $metainfo = array();
                    $post_counter = 0;
                    while (have_posts()) {
                        the_post();
                        renderPost();
                        $post_counter++;
                    }
                    ?>
                </div>
                <nav class="navigation paging-navigation" role="navigation">
                    <h1 class="wprl-screen-reader-text">Works navigation</h1>
                    <div class="wprl-work-links nav-links">
                        <?php posts_nav_link(); ?>
                    </div><!-- .nav-links -->
                </nav>
            <?php } else { ?>
                <h3 class="wprl-no-results">No Results</h3>
            <?php } ?>
        </section>
    </main>
<?php get_footer(); ?>