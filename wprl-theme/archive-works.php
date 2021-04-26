<?php
/*FILE: list-archive-works.php
* DESCRIPTION: The template handler for displaying reading list archives
*/
$wprl_options = get_option('wprl_plugin_options');
get_header();

function renderOpeningRowTag()
{ ?>
    <div class="row">
<?php }

function renderClosingRowTag()
{ ?>
    </div>
<?php }

function renderImage()
{
    global $wprl_options;
    global $post;
    $worklink = get_post_meta($post->ID, "wprl_link", true);
    $includeHyperlink = $worklink && $wprl_options['show_url'];
    $image_src = $wprl_options['cover_image'];
    if (has_post_thumbnail()) {
        $image_src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full')[0];
    }
    if ($includeHyperlink) { ?>
        <a href="<?php echo esc_url($worklink) ?>" target="_blank">
            <img src="<?php echo esc_url($image_src); ?>"/>
        </a>
    <?php } else { ?>
        <img src="<?php echo esc_url($image_src); ?>"/>
    <?php }
}

function renderExcerpt()
{
    global $wprl_options; // only show excerpt in list view
    if ($wprl_options['layout'] == 'list' && $wprl_options['show_list_excerpt']) { ?>
        <p><?php echo wprl_custom_excerpt(55); ?></p>
    <?php }
}

function renderTitle() {
    global $wprl_options;
    global $metapost;
    $title = get_the_title($metapost->ID);
    $permalink = get_permalink($metapost->ID);
    if ($wprl_options['show_single_work']) { ?>
        <a href="<?php echo($permalink); ?>">
            <h2 class="entry-title">
                <?php echo($title); ?>
            </h2>
        </a>
    <?php } else { ?>
        <h2 class="entry-title">
            <?php echo($title); ?>
        </h2>
    <?php }
}

function renderAuthors() {
    global $wprl_options;
    global $metapost;
    $authorlist = get_the_terms($metapost->ID, 'work-author');
    if ($wprl_options['show_author'] && $authorlist) {
        $formattedAuthorlist = "";
        $j = 1;
        $k = 0;
        $numItems = count($authorlist);
        foreach ($authorlist as $author) {
            $authorName = trim($author->name);
            $name = str_replace(' ', '-', trim($author->name)) . '/';
            if (++$k === $numItems && $numItems != 1) {
                $formattedAuthorlist .= ', & ';
            } elseif ($j != 1) {
                $formattedAuthorlist .= ', ';
            }
            if ($wprl_options['show_author_link']) {
                $formattedAuthorlist .= '<a href="'.site_url().'/reading-list/author/'.$name.'">'.$authorName.'</a>';
            } else {
                $formattedAuthorlist.= $authorName;
            }
            $j++;
        }
        ?>
        <p class="work-author">
            By: <?php echo $formattedAuthorlist;?>
        </p>
    <?php }
}

function renderPageNumbers() {
    global $wprl_options;
    global $post;
    global $metapost;
    if ($wprl_options['show_page_nums'] && get_post_meta($post->ID, 'wprl_pages', true)) { ?>
        <p id="work-pages">
            Pages: <?php echo(get_post_meta($metapost->ID, 'wprl_pages', true)); ?>
        </p>
    <?php }
}

function renderPostDate() {
    global $wprl_options;
    global $metapost;
    if ($wprl_options['show_post_date']) { ?>
        <p id="work-time">
            Posted on: <?php echo(get_the_time(get_option('date_format'), $metapost->ID)); ?>
        </p>
    <?php }
}

function renderPostAuthor() {
    global $wprl_options;
    global $metapost;
    if ($wprl_options['post_author']) {
        $postAuthor = get_the_author_meta('user_nicename', $metapost->post_author);
        $postAuthorUrl = site_url().'/author/'.$postAuthor?>
        <p id="post-author">
            Posted by: <a href="<?php echo($postAuthorUrl); ?>">
                <?php echo($postAuthor); ?>
            </a>
        </p>
    <?php }
}

function renderPostType () {
    global $wprl_options;
    global $metapost;
    if ($wprl_options['show_work_type']) {
        $typelist = get_the_terms($metapost->ID, 'work-type');
        if ($typelist) {
            $j = 1;
            $k = 0;
            $numItems = count($typelist);
            $formattedTypeList = "";
            foreach ($typelist as $type) {
                $name = str_replace(' ', '-', trim($type->name)) . '/';
                $typeName = trim($type->name);
                if (++$k === $numItems && $numItems != 1) {
                    $formattedTypeList .= ' & ';
                } elseif ($j != 1) {
                    $formattedTypeList .= ', ';
                }
                if ($wprl_options['show_type_link']) {
                    $formattedTypeList .= '<a href="' . site_url() . '/reading-list/type/' . $name . '">' . $typeName . '</a>';
                } else {
                    $formattedTypeList .= $typeName;
                }
                $j++;
            } ?>
            <p id="work-type">
                Type: <?php echo $formattedTypeList?>
            </p>
        <?php }
    }
}

function renderMetadata() {
    global $metapost;
    $metainfo[] = get_post();
    foreach ($metainfo as $metapost) { ?>
        <div class="entry-meta">
            <?php renderTitle();
            renderAuthors();
            renderPageNumbers();
            renderPostDate();
            renderPostAuthor();
            renderPostType();?>
        </div>
    <?php }
}

function renderPost()
{ ?>
    <article id="post-<?php the_ID(); ?>" class="col col-sm-12 col-md-6 col-lg-3">
        <?php
        renderImage();
        renderExcerpt();
        renderMetadata();
        ?>
    </article><!-- #post-<?php the_ID(); ?> -->
<?php }

?>
    <main id="wp-reading-list" role="main">
        <h1 class="entry-title">
            <?php echo($wprl_options['multiple_title']); ?>
        </h1>
        <section class="full-screen-grid-container">
            <?php if (have_posts()) {
                $posts = $wp_query->found_posts;
                $rows = $wprl_options['grid_rows'];
                $width = $wprl_options['grid_width'];
                $metainfo = array();
                $post_counter = 0;
                while (have_posts()) {
                    the_post();
                    if ($post_counter == 0 || $post_counter % $width === 0) {
                        renderOpeningRowTag();
                    }
                    renderPost();
                    if ($post_counter != 0 && $post_counter % $width === 0) {
                        renderClosingRowTag();
                    }
                    $post_counter++;
                } ?>
                <nav class="navigation paging-navigation" role="navigation">
                    <h1 class="screen-reader-text">Works navigation</h1>
                    <div class="wprl-work-links nav-links">
                        <?php posts_nav_link(); ?>
                    </div><!-- .nav-links -->
                </nav>
            <?php } else { ?>
                <h3 class="entry-header">No Results</h3>
            <?php } ?>
        </section>
    </main>
<?php get_footer(); ?>