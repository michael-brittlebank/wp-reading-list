<?php
/*FILE: list-archive-works.php
* DESCRIPTION: The template handler for displaying reading list archives
*/
require 'render-work.php';
$wprl_options = get_option('wprl_plugin_options');
get_header();

?>
    <main class="wprl-container" role="main">
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
                    while (have_posts()) {
                        the_post();
                        renderPost();
                    }
                    ?>
                </div>
            <?php renderNavigation();
            } else {
                renderNoResults();
            } ?>
        </section>
    </main>
<?php get_footer(); ?>